<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketSoal;

class PaketSoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaketSoal::create([
            'judul' => 'Kuis 1 – Teorema Pythagoras',
            'deskripsi' => 'Kuis dasar teorema Pythagoras',
            'tipe' => 'kuis'
        ]);
    }
}
