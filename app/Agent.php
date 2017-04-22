<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Agent extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name', 'email', 'cell', 'tel', 'about', 'photo'];
    protected $guarded              = [];
}
