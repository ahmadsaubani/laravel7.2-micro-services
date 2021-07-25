<?php

use Database\Seeds\BookSeeder;
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
            $this->call(BookSeeder::class);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e);
        }
    }
}
