<?php

return [
    'secretKey' => env('PAYSTACK_SECRET_KEY'),
    'subAccount' => env('PAYSTACK_SUB_ACCOUNT', 'ACCT_nkrw09lc3hnnlrg'),
    'publicKey' => env('PAYSTACK_PUBLIC_KEY'),
    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    'merchantEmail' => env('MERCHANT_EMAIL'),
];
