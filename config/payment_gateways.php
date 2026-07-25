<?php

use App\Services\Payments\Gateways\PaypalCheckoutGateway;
use App\Services\Payments\Gateways\StripeCheckoutGateway;

return [
    'drivers' => [
        'stripe' => StripeCheckoutGateway::class,
        'paypal' => PaypalCheckoutGateway::class,
    ],
];
