<?php

use Database\Seeds\AuthorSeeder;
use Database\Seeds\ProductsSeeder;
use Database\Seeds\RolesSeeder;
use Database\Seeds\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $this->call(RolesSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(AuthorSeeder::class);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e);
        }
    }
}
