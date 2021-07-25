<?php

namespace Database\Seeds;

use App\Models\Author\Author;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

       $names = [
            ["male", "Udin", "indonesia"],
            ["male", "Rozi", "indonesia"],
            ["male", "Rezo", "indonesia"],
            ["male", "Sukimen", "indonesia"],
            ["male", "Tidung", "indonesia"],
            ["female", "Yuni", "indonesia"],
            ["female", "Yeni", "indonesia"],
            ["female", "Vita", "indonesia"],
            ["female", "Monica", "indonesia"],
            ["female", "Desti", "indonesia"],
        ];

        $index = 0;
        foreach ($names as $value) {
            Author::create([
                "user_id"   => null,
                "gender"    => $value[0],
                "name"      => $value[1],
                "country"   => $value[2]
            ]);
            $index++;
        }
    }
}
