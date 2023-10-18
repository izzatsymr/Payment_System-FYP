<?php

namespace Database\Seeders;

use App\Models\Scanner;
use Illuminate\Database\Seeder;

class ScannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scanner::factory()
            ->count(5)
            ->create();
    }
}
