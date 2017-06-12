<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Owner extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['property_id', 'unit_id', 'contact_type_id', 'contact_id'];
    protected $guarded              = [];

    public function properties()
    {
        return $this->belongsTo('App\Property');
    }

    //  public function contacts()
    // {
    //      return $this->belongsToMany('App\Contact');
    //  }

}
