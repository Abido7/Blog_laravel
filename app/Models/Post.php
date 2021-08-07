<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'caotion',
        'user_id',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}