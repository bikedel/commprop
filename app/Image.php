<?php

namespace App;

use App\Property;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Image extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['property_id', 'unit_id', 'order', 'name', 'caption'];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
