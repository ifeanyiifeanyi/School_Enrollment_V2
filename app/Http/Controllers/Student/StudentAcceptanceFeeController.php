<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Yabacon\Paystack;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AcceptanceFee;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentAcceptanceFeeController extends Controller
{
    public function create()
    {
        return view('student.acceptance_fee.create');
    }

    public function processPayments(Request $request)
    {
        $user = auth()->user();


        // fetch the current academic Session
        $academic_session = AcademicSession::where('status', 'current')->first();

        // fetch the selected department
        $department = Department::where('id', $request->department_id)->first();
        // dd($department);



        // Check if the user has already paid the acceptance fee
        $paidFee = AcceptanceFee::where('user_id', $user->id)
            ->where('status', 'paid')
            ->first();

        if ($paidFee) {
            return redirect()->route('student.dashboard')->with('info', 'You have already paid your acceptance fee.');
        }

        // Create a new acceptance fee record
        $acceptanceFee = new AcceptanceFee([
            'user_id' => $user->id,
            'amount' => 40450, // 40,000 Naira + 450 Naira processing fee
            'academic_year' => $academic_session->session,
            'department' => $department->name,
            'status' => 'pending',
            'due_date' => now()->addDays(14), // Set due date to 14 days from now
        ]);

        $acceptanceFee->save();

        try {
            $paystack = new Paystack(config('paystack.secretKey'));

            $reference = $this->generateUniqueReference();

            // Define subaccount details
            $subAccountCode = config('paystack.subAccount');

            $transaction = $paystack->transaction->initialize([
                'email' => $user->email,
                'amount' => $acceptanceFee->amount * 100, // Convert to kobo
                'reference' => $reference,
                'callback_url' => route('student.acceptance_fee.callback'),
                'subaccount' => $subAccountCode,
                'bearer' => 'subaccount', // Ensures the fee is borne by the sub-account
                'metadata' => [
                    'acceptance_fee_id' => $acceptanceFee->id,
                    'academic_year' => $acceptanceFee->academic_year,
                    'department' => $acceptanceFee->department,
                ]
            ]);

            // Update the acceptance fee record with the transaction reference
            $acceptanceFee->update([
                'transaction_id' => $reference,
            ]);

            // Redirect to Paystack payment page
            return redirect($transaction->data->authorization_url);
        } catch (\Exception $e) {
            Log::error('Paystack Error: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while initiating the payment. Please try again later.');
        }
    }


    public function handleCallback(Request $request)
    {
        $paystack = new Paystack(config('paystack.secretKey'));

        try {
            DB::beginTransaction();

            $transaction = $paystack->transaction->verify([
                'reference' => $request->reference,
            ]);

            if ($transaction->data->status === 'success') {
                $acceptanceFee = AcceptanceFee::where('transaction_id', $request->reference)->firstOrFail();
                $user = User::findOrFail($acceptanceFee->user_id);

                $acceptanceFee->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                DB::commit();

                // You can add any additional logic here, like sending an email

                return view('student.acceptance_fee.success', [
                    'user' => $user,
                    'acceptanceFee' => $acceptanceFee,
                ]);
            } else {
                DB::rollBack();
                return redirect()->route('student.pay_acceptance_fee.create')
                    ->withErrors('Payment was not successful. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing acceptance fee payment', ['message' => $e->getMessage()]);
            return redirect()->route('student.pay_acceptance_fee.create')
                ->withErrors('An error occurred while processing the payment. Please try again.');
        }
    }

    private function generateUniqueReference()
    {
        $userId = auth()->id();
        $timestamp = now()->timestamp;
        $randomString = Str::random(5);
        return "AF-{$userId}-{$timestamp}-{$randomString}";
    }


    public function success(){
        return view('student.acceptance_fee.success');
    }

    public function viewReceipt(){
        $user = auth()->user();
        $acceptanceFee = AcceptanceFee::where('user_id', $user->id)->first();

        if (!$acceptanceFee) {
            return redirect()->route('student.pay_acceptance_fee.create');
        }

        return view('student.acceptance_fee.receipt', compact('user', 'acceptanceFee'));
    }
}
