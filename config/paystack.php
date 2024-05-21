<?php

return [
    'secretKey' => env('PAYSTACK_SECRET_KEY'),
    'publicKey' => env('PAYSTACK_PUBLIC_KEY'),
    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    'merchantEmail' => env('MERCHANT_EMAIL'),
];