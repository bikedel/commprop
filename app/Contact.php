<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['company', 'firstname', 'lastname', 'tel', 'cell', 'email', 'website'];
    protected $guarded              = [];

    public function properties()
    {
        return $this->hasManyThrough('App\Property', 'App\Owner', 'property_id', 'id', 'contact_id');
    }

}
