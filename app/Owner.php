<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //
    protected $guarded = [];

    public function properties()
    {
        return $this->belongsTo('App\Property');
    }
}
