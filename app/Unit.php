<?php

namespace App;

use App\Property;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['property_id', 'property_type_id', 'sale_type_id', 'size', 'price'];
    protected $guarded              = [];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function notes()
    {
        return $this->hasMany('App\Note');
    }

    public function owners()
    {
        return $this->hasMany('App\Owner');
    }

    public function delete()
    {
        // delete all related records

        $this->images()->delete();
        $this->notes()->delete();
        $this->owners()->delete();

        // delete the user
        return parent::delete();
    }

}
