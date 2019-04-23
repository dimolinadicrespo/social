<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes it will be included in both the model's array and JSON representations.
     *
     * @var array
     */
    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        return $this->avatar();
    }


    public function link()
    {
        return route('users.show',$this);
    }
    public function avatar()
    {
        return "https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1";
    }
    public function getRouteKeyName()
    {
        return 'name';
    }
}
