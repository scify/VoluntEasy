<?php

return [

    /*
    | Each deployment flavour (see "mode" in config/app.php) keeps its own
    | views in dependencies/<mode>/resources/views, so that folder is also
    | a view path.
    */

    'paths' => [
        resource_path('views'),
        base_path('dependencies'),
    ],

    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),

];
