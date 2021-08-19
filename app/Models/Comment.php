<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id'
    ];
    public function commentable()
    {
        return $this->morphTo();
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function user()
    {
        return $this->belongsTo(User::class)->where('status', '=', 1);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function deletedImage()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}