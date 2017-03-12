<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function suburbs()
    {
        return $this->hasMany('App\Suburb');
    }
}
