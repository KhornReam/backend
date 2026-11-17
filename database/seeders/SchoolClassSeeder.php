<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([10, 11, 12] as $grade) {
            foreach (['A', 'B', 'C'] as $section) {
                SchoolClass::query()->firstOrCreate([
                    'grade' => $grade,
                    'section' => $section,
                ]);
            }
        }
    }
}
