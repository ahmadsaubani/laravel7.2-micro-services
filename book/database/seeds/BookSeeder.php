<?php

namespace Database\Seeds;

use App\Models\Book\Book;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker();
        $i= 0;
        $names = [
            ["buku-1", "ini buku-1", "25", "1"],
            ["buku-2", "ini buku-2", "15", "2"],
            ["buku-3", "ini buku-3", "12", "3"],
            ["buku-4", "ini buku-4", "25", "4"],
            ["buku-5", "ini buku-5", "25", "5"],
            ["buku-6", "ini buku-6", "25", "6"],
            ["buku-7", "ini buku-7", "25", "7"],
            ["buku-8", "ini buku-8", "25", "8"],
            ["buku-9", "ini buku-9", "25", "9"],
            ["buku-10", "ini buku-10", "25", "10"],
            ["buku-11", "ini buku-11", "25", "1"],
            ["buku-12", "ini buku-12", "25", "2"],
            ["buku-13", "ini buku-13", "25", "3"],
        ];
        foreach ($names as $value) {
            Book::create([
                "title"             => $value[0],
                "description"       => $value[1],
                "price"             => $value[2],
                "author_id"         => $value[3],
            ]);
        }
    }
}
