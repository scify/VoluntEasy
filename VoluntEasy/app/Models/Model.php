<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsMysql;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Base class of all the models of the application.
 */
abstract class Model extends EloquentModel
{
    use SerializesDatesAsMysql;
}
