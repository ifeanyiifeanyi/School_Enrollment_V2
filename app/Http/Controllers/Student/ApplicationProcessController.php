<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Payment;
use App\Models\Department;
use App\Models\Application;
use App\Models\AcademicSession;
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

        // Get current academic session
        $currentSession = AcademicSession::where('status', 'current')->first();

        // Get application for CURRENT session only
        $application = $user->applications()
            ->where('academic_session_id', $currentSession->id ?? null)
            ->first();

        // Check if user has been APPROVED/ADMITTED in any PREVIOUS session (not current session)
        // Students can reapply if they were denied or pending in previous sessions, regardless of payment
        $hasBeenApprovedInPreviousSession = $user->applications()
            ->where('admission_status', 'approved')
            ->where('academic_session_id', '!=', $currentSession->id ?? null)
            ->exists();

        if ($hasBeenApprovedInPreviousSession) {
            return redirect()->route('student.dashboard')
                ->with('info', 'You have already been admitted in a previous session and cannot apply again.');
        }

        // Check if application exists for current session and payment is pending
        if ($application && $application->payment_id == null) {
            $paymentMethods = PaymentMethod::latest()->get();

            return view('student.payment.index', compact(
                'user',
                'application',
                'paymentMethods'
            ));
        }

        // If payment is completed for current session, redirect to dashboard
        if ($application && $application->payment_id != null) {
            return redirect()->route('student.dashboard')
                ->with('info', 'Your application is complete and payment has been received.');
        }

        // If no application exists for current session, redirect to dashboard
        return redirect()->route('student.dashboard')
            ->with('error', 'No application found for current session.');
    }


    // process flutterWave
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required'
        ], [
            'payment_method_id.required' => "Please Select Payment Option to Proceed, Thank you."
        ]);

        $user = auth()->user();

        // Additional check to prevent approved students from making payments
        $hasBeenApproved = $user->applications()
            ->where('admission_status', 'approved')
            ->exists();

        if ($hasBeenApproved) {
            return redirect()->route('student.dashboard')
                ->with('info', 'You have already been admitted and cannot make another payment.');
        }

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
                    ],
                ];

                $payment = Flutterwave::initializePayment($data);

                if ($payment['status'] !== 'success') {
                    return redirect()->back()->withErrors('An error occurred while processing the payment.');
                }

                return redirect($payment['data']['link']);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
            }
        } else if ($paymentMethod->name == "Paystack") {
            try {
                $paystack = new \Yabacon\Paystack(config('paystack.secretKey'));

                $baseAmount = $paymentAmount;
                $additionalCharges = 1450; // This goes to your main account
                $totalAmount = $baseAmount + $additionalCharges;

                $transaction = $paystack->transaction->initialize([
                    'email' => $user->email,
                    'amount' => $totalAmount * 100, // Total amount customer pays (including charges)
                    'reference' => $this->generateUniqueReference(),
                    'callback_url' => route('student.payment.callbackPaystack'),
                    'channels' => ['card'], // Restrict to card payments only
                    'subaccount' => 'ACCT_nkrw09lc3hnnlrg', // Subaccount receives the base amount
                    'transaction_charge' => $additionalCharges * 100, // Your charges (goes to main account)
                    'bearer' => 'account' // Subaccount bears the Paystack fees
                ]);

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

                // Get current session application
                $currentSession = AcademicSession::where('status', 'current')->first();
                $application = $user->applications()
                    ->where('academic_session_id', $currentSession->id)
                    ->first();

                $paymentMethod = PaymentMethod::where('name', 'Paystack')->firstOrFail();

                $paymentData = [
                    'user_id' => $user->id,
                    'amount' => $transaction->data->amount / 100,
                    'payment_method' => 'Paystack',
                    'payment_status' => 'Successful',
                    'transaction_id' => $transaction->data->reference,
                    'payment_method_id' => $paymentMethod->id,
                ];

                $payment = Payment::create($paymentData);
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

                $user = User::where('email', $data['data']['customer']['email'])->first();

                if ($user) {
                    // Get current session application
                    $currentSession = AcademicSession::where('status', 'current')->first();
                    $application = $user->applications()
                        ->where('academic_session_id', $currentSession->id)
                        ->first();

                    $paymentMethodId = PaymentMethod::where('name', 'Flutterwave')->first()->id;

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
            $userSlug = optional(auth()->user())->nameSlug;
            return redirect()->route('payment.view.finalStep', ['userSlug' => $userSlug])
                ->withErrors('An error occurred while processing the payment. Please try again.');
        }
    }

    public function showSuccess()
    {
        $user = auth()->user();
        $currentSession = AcademicSession::where('status', 'current')->first();
        $application = $user->applications()
            ->where('academic_session_id', $currentSession->id)
            ->first();
        $payment = $application ? $application->payment : null;

        $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);

        if (!$payment || !$user || !$application) {
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
                ->withErrors('An error occurred while processing the payment. Please try again.');
        }

        return view('student.payment.success', compact('user', 'application', 'payment', 'barcodeUrl'));
    }

    public function viewPaymentSlip()
    {
        $user = auth()->user();
        $currentSession = AcademicSession::where('status', 'current')->first();
        $application = $user->applications()
            ->where('academic_session_id', $currentSession->id)
            ->first();

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
