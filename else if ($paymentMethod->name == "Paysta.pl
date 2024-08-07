 else if ($paymentMethod->name == "Paystack") {
            try {
                DB::beginTransaction();
                $paystack = new \Yabacon\Paystack(config('paystack.secretKey'));

                // Define subaccount details
                $subAccountCode = config('paystack.subAccount');

                $transaction = $paystack->transaction->initialize([
                    'email' => $user->email,
                    'amount' => $paymentAmount * 100, // Convert amount to kobo
                    'reference' => $this->generateUniqueReference(),
                    'callback_url' => route('student.payment.callbackPaystack'),
                    'subaccount' => $subAccountCode,
                    'bearer' => 'subaccount' // Ensures the fee is borne by the sub-account
                ]);
                DB::commit();
                return redirect($transaction->data->authorization_url);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in making payment: ' . $e->getMessage(), [
                    'exception' => $e
                ]);
                return redirect()->back()->withErrors('An error occurred, Please Try again later ... ');
            }
        }