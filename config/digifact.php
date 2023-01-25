<?php

return [
    'url' => env('APP_ENV', 'local') == 'production' ? env('API_DIGIFACT_URL_PROD') : env('API_DIGIFACT_URL_TEST'),
    'ruc' => env('APP_ENV', 'local') == 'production' ? env('API_DIGIFACT_RUC_PROD') : env('API_DIGIFACT_RUC_TEST'),
    'username' => env('APP_ENV', 'local') == 'production' ? env('API_DIGIFACT_USERNAME_PROD') : env('API_DIGIFACT_USERNAME_TEST'),
];
