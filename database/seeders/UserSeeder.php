<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(4)->create()->each(function ($user) {

            Image::factory()->create([
                'img' => "users/$user->id.jpg",
                "imageable_id" => $user->id,
                "imageable_type" => $user::class,
            ]);
        });
    }
}