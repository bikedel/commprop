<?php

namespace App;

use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
    use LogsActivity;

    protected static $logAttributes = ['name', 'email', 'agent_id', 'role_id', 'avatar'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role_id', 'agent_id', 'avatar', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRoleName()
    {
        $role = Role::find($this->role_id)->name;
        return $role; // this looks for an admin column in your users table
    }

    public function getRoleId()
    {

        return $this->role_id; // this looks for an admin column in your users table
    }

}
