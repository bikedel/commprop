<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Property extends Model
{
    //
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    use LogsActivity;

    protected $guarded              = [];
    protected static $logAttributes = ['erf', 'title', 'description', 'address', 'street', 'long', 'lat', 'area_id', 'grade_id', 'type', 'erf_size', 'buildinf_size', 'open_parking_bays', 'closed_parking_bays', 'image_id', 'sale_type_id'];

    public function units()
    {
        return $this->hasMany('App\Unit');
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
        $this->units()->delete();
        $this->images()->delete();
        $this->notes()->delete();
        $this->owners()->delete();

        // delete the user
        return parent::delete();
    }
}
