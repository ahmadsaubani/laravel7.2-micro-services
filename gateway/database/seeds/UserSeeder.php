<?php

namespace Database\Seeds;

use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Admin admin',
            'Ahmad Saubani',
            'Ahmad Subhan',
            'Jarvis Mcintyre',
            'Tiya Duarte',
            'Haidar Farmer',
            'Danny Farrington',
            'Shamas Ingram',
            'Nathan Finley',
            'Zuzanna Bruce',
            'Sarah Kennedy'
        ];
        
        for ($i = 1; $i <= 11; $i++) {
            $name = strtolower(str_replace(' ', '.', $names[$i-1]));
            $sliceName = explode(" ", $names[$i-1]);
            $user = User::create([
                'id'                => $i,
                'first_name'        => $sliceName[0],
                'last_name'         => $sliceName[1],
                "username"          => $name,
                'email'             => $name ."@ahmadsaubani.com",
                'email_verified_at' => Carbon::now(),
                'password'          => Hash::make('password')
            ]);

            if ($i == 1) {
                $user->userRoles()->create([
                    "user_id"   => $user->id,
                    "role_id"   => Roles::where("id", 1)->first()->id
                ]);
            } else {
                $user->userRoles()->create([
                    "user_id"   => $user->id,
                    "role_id"   => Roles::where("id", 2)->first()->id,
                ]);
            }
        }
    }
}
