<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $moviesList = Movie::all();

        foreach ($moviesList as $movie) {
            $count = rand(2, 6);
            for ($i = 0; $i < $count; $i++) {
                Comment::create([
                    'content'   => $faker->paragraph(),
                    'title'     => $faker->optional()->sentence(),
                    'movie_id'  => $movie->id,
                    'author_id' => rand(1, 10),
                ]);
            }
        }
    }
}
