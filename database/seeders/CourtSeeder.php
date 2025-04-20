<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     // This function is to create 6 courts with the details
    public function run()
    {
        $statuses = ['available', 'not_available'];

        for ($i = 1; $i <= 6; $i++) {
            DB::table('courts')->insert([
                'name' => 'Court ' . $i,
                'image' => 'court_' . $i . '.jpg',
                'price' => 5.00,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
