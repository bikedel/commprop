<?php

namespace App;

use App\Property;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $guarded = [];
    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
