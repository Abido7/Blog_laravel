<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cesargb\Database\Support\CascadeDelete;

class Post extends Model
{
    use HasFactory, Likeable, CascadeDelete;

    protected $fillable = [
        'caption',
        'user_id',
    ];

    protected $cascadeDeleteMorph = ['images', 'comments', 'likes'];

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
        return $this->belongsTo(User::class)->where('is_active', '=', 1);
    }

    public function latestComment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }

    public function deletedComment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }
}