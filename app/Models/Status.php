<?php

namespace App\Models;

use App\User;
use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasLikes;

    protected $guarded = [];

    // ******** RELACIONES
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public  function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
