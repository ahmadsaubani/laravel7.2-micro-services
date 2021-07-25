<?php

namespace Database\Seeds;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            "admin",
            "user"
        ];

        $index = 0;
        foreach ($names as $value) {
            if ($index == 0) {
                Roles::updateOrCreate(
                    [
                        "title"     => $value
                    ],
                    [
                        "title"     => $value,
                        "isHidden"  => true,
                    ]
                );
            } else {
                Roles::updateOrCreate(
                    [
                        "title"     => $value
                    ],
                    [
                        "title"     => $value
                    ]
                );
            }
            $index++;
        }
    }
}
