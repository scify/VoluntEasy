<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Extends the routing controller so that the controllers can keep
 * registering middleware in their constructors.
 */
abstract class Controller extends BaseController
{
    use ValidatesRequests;
}
