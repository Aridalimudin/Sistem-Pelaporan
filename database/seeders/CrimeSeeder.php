<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crime = [
            [
                'name' => 'Hinaan',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Ejekan',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Panggilan buruk',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Cemoohan',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Penghinaan',
                'type' => 'Bullying Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Sindiran',
                'type' => 'Bullying Verbal',
                'urgency' => 1
            ],
            [
                'name' => 'Olok-olokan',
                'type' => 'Bullying Verbal',
                'urgency' => 1
            ],
            [
                'name' => 'Dikatakan bodoh',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Dikatakan tidak berguna',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Makian',
                'type' => 'Bullying Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Umpatan',
                'type' => 'Bullying Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'kata-kata kasar',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Mempermalukan',
                'type' => 'Bullying Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Menyebar foto memalukan',
                'type' => 'Bullying Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Sebar info pribadi',
                'type' => 'Bullying Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Gosip buruk',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Meneriaki',
                'type' => 'Bullying Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Tampar',
                'type' => 'Bullying Fisik',
                'urgency' => 2
            ],
            [
                'name' => 'Pukul',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Serang',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Dorong',
                'type' => 'Bullying Fisik',
                'urgency' => 2
            ],
            [
                'name' => 'Tekan',
                'type' => 'Bullying Fisik',
                'urgency' => 2
            ],
            [
                'name' => 'Hajar',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Tumbuk',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Tikam',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Tendang',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Lempar',
                'type' => 'Bullying Fisik',
                'urgency' => 2
            ],
            [
                'name' => 'Gigit',
                'type' => 'Bullying Fisik',
                'urgency' => 2
            ],
            [
                'name' => 'Cengkeram',
                'type' => 'Bullying Fisik',
                'urgency' => 2
            ],
            [
                'name' => 'Ancaman kekerasan',
                'type' => 'Bullying Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Cabul',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Goda',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Komentar seksual',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Ajakan tidak pantas',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Mengomentari tubuh',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Panggilan seksual',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 3
            ],
            [
                'name' => 'Lelucon seksual',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Pesan negatif',
                'type' => 'Pelecehan Seksual Verbal',
                'urgency' => 2
            ],
            [
                'name' => 'Raba',
                'type' => 'Pelecehan Seksual Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Sentuh',
                'type' => 'Pelecehan Seksual Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Cium',
                'type' => 'Pelecehan Seksual Fisik',
                'urgency' => 3
            ],
            [
                'name' => 'Peluk',
                'type' => 'Pelecehan Seksual Fisik',
                'urgency' => 3
            ],
        ];

        DB::table('crimes')->truncate();
        DB::table('crimes')->insert($crime);
    }
}
