<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker::create('id_ID');

        // Membuat data siswa
        DB::table('students')->truncate();
        foreach (range(1, 30) as $index) {
            DB::table('students')->insert([
                'nis' => $faker->unique()->numerify('#########'),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'classroom' => '7-' . $faker->randomElement(['A', 'B', 'C']),
            ]);
        }
    }
}
