<?php

namespace App\Models;

use App\User;
use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasLikes;

    protected $guarded = [];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
