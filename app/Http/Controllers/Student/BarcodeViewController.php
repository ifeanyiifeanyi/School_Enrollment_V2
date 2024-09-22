<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AcceptanceFee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BarcodeViewController extends Controller
{
    public function showDetails($nameSlug) {
        try {
            $user = User::with('student', 'applications.department')
                ->where('nameSlug', $nameSlug)
                ->firstOrFail();

            return view('student.qrcode.details', compact('user'));
        } catch (ModelNotFoundException $e) {
            return view('errors.user-not-found');
        }
        // dd($user);
    }

    public function receiptDetail($transactionId) {
        // implement receipt detail page for acceptance fee payment
        $acceptanceFee = AcceptanceFee::where('transaction_id', $transactionId)->first();

        if (!$acceptanceFee) {
            return view('student.acceptance_fee.public_receipt', [
                'status' => 'not_found',
                'message' => 'No payment record found for this transaction ID.'
            ]);
        }

        $user = User::findOrFail($acceptanceFee->user_id);

        if ($acceptanceFee->status !== 'paid') {
            return view('student.acceptance_fee.public_receipt', [
                'status' => 'pending',
                'message' => 'This payment is still pending or has not been completed.',
                'user' => $user,
                'acceptanceFee' => $acceptanceFee
            ]);
        }

        return view('student.acceptance_fee.public_receipt', [
            'status' => 'verified',
            'message' => 'Payment verified successfully.',
            'user' => $user,
            'acceptanceFee' => $acceptanceFee
        ]);

        // return view('student.acceptance_fee.public_receipt', compact('transaction'));
    }
}
