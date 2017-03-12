<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{
    public function areas()
    {
        return $this->hasMany('App\Area');
    }
}
