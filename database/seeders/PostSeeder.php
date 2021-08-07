<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(20)->create()->each(function ($post) {
            Comment::factory()->count(10)->create([
                "commentable_id" => $post->id,
                "commentable_type" => $post::class,
            ]);
            Image::factory()->count(1)->create([
                'img' => "posts/$post->id.jpg",
                "imageable_id" => $post->id,
                "imageable_type" => $post::class,
            ]);
            Like::factory()->count(5)->create([
                "likeable_id" => $post->id,
                "likeable_type" => $post::class,
            ]);
        });
    }
}