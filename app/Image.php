<?php

namespace App;

use App\Property;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
