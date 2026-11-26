<?php

return [

    /*
    | The public JSON API under /api is read by the application itself and by
    | third-party sites (for example the public volunteer form).
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Accept', 'Content-Type', 'X-Auth-Token', 'Origin', 'X-Requested-With', 'Authorization'],

    'exposed_headers' => [],

    'max_age' => 30,

    'supports_credentials' => false,

];
