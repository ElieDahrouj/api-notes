<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Notes;
class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $post = new Notes();
            $post->content = $faker->realText(100);
            $post->save();
        }
    }
}
