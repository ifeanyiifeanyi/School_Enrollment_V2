<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Payment;
use App\Models\Department;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Yabacon\Paystack\Paystack;

use Illuminate\Support\Facades\DB;
use App\Mail\ApplicationStatusMail;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yabacon\Paystack\PaystackClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use Unicodeveloper\Flutterwave\Facades\Flutterwave as UnicodeveloperFlutterwave;



class ApplicationProcessController extends Controller
{

    public function finalApplicationStep(Request $request, string $userSlug)
    {
        $user = User::where('nameSlug', $userSlug)->firstOrFail();
        $application = $request->application; // This is passed from the middleware

        // If the application exists but payment is pending
        if ($application->payment_id == null) {
            $paymentMethods = PaymentMethod::latest()->get();
            // dd($paymentMethods);

            return view('student.payment.index', compact(
                'user',
                'application',
                'paymentMethods'
            ));
        }

        // If payment is completed, redirect to the appropriate next step
        return redirect()->route('student.dashboard')
            ->with('info', 'Your application is complete and payment has been received.');
    }




    // process flutterWave
    public function processPayment(Request $request)
    {
        // dd($request);
        $request->validate([
            'payment_method_id' => 'required'
        ], [
            'payment_method_id.required' => "Please Select Payment Option to Proceed, Thank you."
        ]);

        $user = auth()->user();


        $reference = Flutterwave::generateReference();

        $paymentAmount = $request->amount;
        $paymentMethodId = $request->payment_method_id;

        $paymentMethod = PaymentMethod::find($paymentMethodId);


        if ($paymentMethod->name == "Flutterwave") {
            try {
                $data = [
                    'tx_ref' => $reference,
                    'amount' => $paymentAmount,
                    'currency' => 'NGN',
                    'email' => $user->email,
                    'redirect_url' => route('student.payment.callbackFlutter'),
                    'payment_options' => 'card',
                    'customer' => [
                        'email' => $user->email,
                        "phone_number" => $user->student->phone,
                        "name" => $user->first_name . " " . $user->last_name
                    ],
                    'customizations' => [
                        'title' => 'Application Payment',
                        // 'description' => 'Payment for application #' . $application->invoice_number,
                    ],
                ];


                $payment = Flutterwave::initializePayment($data);

                if ($payment['status'] !== 'success') {
                    return redirect()->back()->withErrors('An error occurred while processing the payment.');
                }

                // $transactionId = $payment;
                // dd($transactionId);

                return redirect($payment['data']['link']);
            } catch (\Exception $e) {
                dd($e->getMessage());

                return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
            }
        } else if ($paymentMethod->name == "Paystack") {
            try {
                $paystack = new \Yabacon\Paystack(config('paystack.secretKey'));

                $baseAmount = $paymentAmount; // Amount to go to subaccount (in Naira)
                $additionalCharges = 1450; // Additional charges (in Naira)
                $totalAmount = $baseAmount + $additionalCharges; // Total to charge customer


                $transaction = $paystack->transaction->initialize([
                    'email' => $user->email,
                    'amount' => $totalAmount * 100, // Convert total to kobo (₦11,450)
                    'reference' => $this->generateUniqueReference(),
                    'callback_url' => route('student.payment.callbackPaystack'),
                    'subaccount' => 'ACCT_nkrw09lc3hnnlrg',
                    'transaction_charge' => $additionalCharges * 100, // Set to 0 to ensure subaccount gets full amount
                    'bearer' => 'account' // Main account bears all transaction fees
                ]);
                dd($transaction);
                // session(['paystack_reference' => $this->generateUniqueReference()]);


                return redirect($transaction->data->authorization_url);
            } catch (\Yabacon\Paystack\Exception\ApiException $e) {
                Log::error('Paystack API Error: ' . $e->getMessage(), [
                    'exception' => $e
                ]);

                return redirect()->back()->withErrors('An error occurred while initializing the payment. Please try again later.');
            } catch (\Exception $e) {
                Log::error('Error in making payment: ' . $e->getMessage(), [
                    'exception' => $e
                ]);
                return redirect()->back()->withErrors('An unexpected error occurred. Please try again later.');
            }
        } else {
            return redirect()->back()->withErrors('Payment Method not found.');
        }
    }



    public function handlePaymentCallBackPayStack(Request $request)
    {
        $paystack = new \Yabacon\Paystack(config('paystack.secretKey'));


        try {

            $transaction = $paystack->transaction->verify([
                'reference' => $request->reference,
            ]);

            if ($transaction->data->status == 'success') {
                DB::beginTransaction();

                $userEmail = $transaction->data->customer->email;

                $user = User::where('email', $userEmail)->firstOrFail();
                $application = $user->applications;
                // dd($application);

                $paymentMethod = PaymentMethod::where('name', 'Paystack')->firstOrFail();



                $paymentData = [
                    'user_id' => $user->id,
                    'amount' => $transaction->data->amount / 100, // Convert kobo to Naira
                    'payment_method' => 'Paystack',
                    'payment_status' => 'Successful',
                    'transaction_id' => $transaction->data->reference,
                    'payment_method_id' => $paymentMethod->id,
                ];

                $payment = Payment::create($paymentData);
                // dd($payment);
                $application->update(['payment_id' => $payment->id]);


                DB::commit();

                // Send email after transaction is committed
                Mail::to($user->email)->send(new ApplicationStatusMail($user, $application, $payment));

                $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);

                return view('student.payment.success', [
                    'user' => $user,
                    'application' => $application,
                    'payment' => $payment,
                    'barcodeUrl' => $barcodeUrl
                ]);
            } else {
                throw new \Exception('Payment was not successful: ' . $transaction->data->gateway_response);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Paystack Payment Error', [
                'message' => $e->getMessage(),
                // 'user_id' => auth()->id(),
                'reference' => $request->reference
            ]);
            return $this->handlePaymentError($e->getMessage());
        }
    }

    private function handlePaymentError($message)
    {
        $userSlug = optional(auth()->user())->nameSlug;
        return redirect()->route('payment.view.finalStep', ['userSlug' => $userSlug])
            ->withErrors($message);
    }

    private function generateUniqueReference()
    {
        return uniqid(auth()->id() . '', true);
    }








    // handle FLUTTER-WAVE payment callback
    public function handlePaymentCallBack(Request $request)
    {
        try {
            $status = $request->input('status');
            if ($status === 'successful') {

                $transactionId = Flutterwave::getTransactionIDFromCallback();
                $data = Flutterwave::verifyTransaction($transactionId);
                // dd($data);

                $user = User::where('email', $data['data']['customer']['email'])->first();

                if ($user) {
                    $application = $user->applications;
                    $paymentMethodId = PaymentMethod::where('name', 'Flutterwave')->first()->id;
                    // dd($paymentMethodId);


                    $paymentData = [
                        'user_id' => $user->id,
                        'amount' => $data['data']['amount'],
                        'payment_method' => 'Flutterwave',
                        'payment_status' => 'Successful',
                        'transaction_id' => $transactionId,
                        'payment_method_id' => $paymentMethodId,
                    ];

                    $payment = Payment::create($paymentData);

                    if ($application) {
                        $application->update(['payment_id' => $payment->id]);
                    }
                    Mail::to($user->email)->send(new ApplicationStatusMail($user, $application, $payment));

                    $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);


                    return view('student.payment.success', [
                        'user' => $user,
                        'application' => $application,
                        'payment' => $payment,
                        'barcodeUrl' => $barcodeUrl
                    ]);
                } else {
                    $userSlug = optional(auth()->user())->nameSlug;
                    return redirect()->route('payment.view.finalStep', ['userSlug' => $userSlug])
                        ->withErrors('Payment was not successful. Please try again.');
                }
            } elseif ($status == 'cancelled') {

                $userSlug = optional(auth()->user())->nameSlug;
                return redirect()->route('payment.view.finalStep', ['userSlug' => $userSlug])
                    ->withErrors('Payment was cancelled.');
            } else {

                $userSlug = optional(auth()->user())->nameSlug;
                return redirect()->route('payment.view.finalStep', ['userSlug' => $userSlug])
                    ->withErrors('Payment was not successful. Please try again.');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());

            // Redirect with an error message
            $userSlug = optional(auth()->user())->nameSlug;
            return redirect()->route('payment.view.finalStep', ['userSlug' => $userSlug])
                ->withErrors('An error occurred while processing the payment. Please try again.');
        }
    }

    public function showSuccess()
    {
        $user = auth()->user();
        $application = $user->applications;
        $payment = $application ? $application->payment : null;

        // Generate URL to the student details page
        $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);


        if (!$payment || !$user || $application) {
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
                ->withErrors('An error occurred while processing the payment. Please try again.');
        }

        return view('student.payment.success', compact('user', 'application', 'payment', 'barcodeUrl'));
    }

    public function viewPaymentSlip()
    {
        $user = auth()->user();
        $application = $user->applications;

        // Generate URL to the student details page
        $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);

        if (!$application || !$application->payment_id) {
            return redirect()->route('student.dashboard')
                ->with('error', 'No completed application found.');
        }

        $payment = Payment::find($application->payment_id);

        return view('student.payment.slip', compact(
            'barcodeUrl',
            'user',
            'application',
            'payment'
        ));
    }
}
