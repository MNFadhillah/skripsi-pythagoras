<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ButirSoal;

class ButirSoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // ButirSoal::create([
        //     'paket_soal_id' => 1,
        //     'pertanyaan' => [
        //         'text' => 'Pada segitiga siku-siku ABC dengan siku-siku di C, rumus Pythagoras adalah …',
        //         'image' => null
        //     ],
        //     'opsi_jawaban' => [
        //         'A' => 'AB² = AC² + BC²',
        //         'B' => 'AC² = AB² + BC²',
        //         'C' => 'BC² = AB² + AC²',
        //         'D' => 'AB² = AC² − BC²',
        //     ],
        //     'kunci_jawaban' => 'A'
        // ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,
            'pertanyaan' => [
                'text' => 'Pada segitiga ABC di bawah berlaku .... ',
                'image' => '/storage/soal/kuis1_nomor1.png',
            ],
            'opsi_jawaban' => [
                'A' => ['text' => 'AB² = AC² - BC²', 'image' => null],
                'B' => ['text' => 'AC² = AB² + BC²', 'image' => null],
                'C' => ['text' => 'BC² = AB² + AC²', 'image' => null],
                'D' => ['text' => 'AB² = AC² − BC²', 'image' => null],
            ],
            'kunci_jawaban' => 'A',
        ]);

        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Perhatikan gambar berikut! Diketahui segitiga siku-siku dengan sisi p, q, dan r seperti pada gambar. Pernyataan yang benar adalah …\n\n(i) r² = p² + q²\n(ii) r² = p² − q²\n(iii) p² = r² − q²\n(iv) q² = r² − p²',
                'image' => '/storage/soal/kuis1_nomor2.png',
            ],

            'opsi_jawaban' => [
                'A' => [
                    'text' => '(i) dan (ii)',
                    'image' => null,
                ],
                'B' => [
                    'text' => '(i) dan (iii)',
                    'image' => null,
                ],
                'C' => [
                    'text' => '(i), (iii), dan (iv)',
                    'image' => null,
                ],
                'D' => [
                    'text' => '(i), (ii), (iii), dan (iv)',
                    'image' => null,
                ],
            ],

            'kunci_jawaban' => 'B',
        ]);

        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Pada segitiga siku-siku PQR dengan siku-siku di titik Q, diketahui panjang PQ = 6 cm dan QR = 8 cm. Hitunglah panjang sisi miring PR!',
                'image' => '/storage/soal/kuis1_nomor3.png'
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '10 cm',  'image' => null],
                'B' => ['text' => '11 cm',  'image' => null],
                'C' => ['text' => '12 cm',  'image' => null],
                'D' => ['text' => '13 cm', 'image' => null],
            ],

            'kunci_jawaban' => 'A'
        ]);

        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Perhatikan gambar berikut. Panjang sisi PQ = … cm',
                'image' => '/storage/soal/nomor4.png'
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '7',  'image' => null],
                'B' => ['text' => '8',  'image' => null],
                'C' => ['text' => '9',  'image' => null],
                'D' => ['text' => '10', 'image' => null],
            ],

            'kunci_jawaban' => 'D'
        ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Panjang sisi miring suatu segitiga siku-siku adalah 15 cm. Jika panjang salah satu sisi siku-sikunya adalah 9 cm, panjang sisi segitiga siku-siku yang lainnya adalah ....',
                'image' => null
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '10 cm',  'image' => null],
                'B' => ['text' => '11 cm',  'image' => null],
                'C' => ['text' => '12 cm',  'image' => null],
                'D' => ['text' => '13 cm', 'image' => null],
            ],

            'kunci_jawaban' => 'A'
        ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Perhatikan gambar berikut! Nilai x dan y yang memenuhi gambar tersebut adalah ....',
                'image' => null
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '14 dan 16',  'image' => null],
                'B' => ['text' => '15 dan 17',  'image' => null],
                'C' => ['text' => '16 dan 18',  'image' => null],
                'D' => ['text' => '17 dan 19', 'image' => null],
            ],

            'kunci_jawaban' => 'B'
        ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Perhatikan gambar berikut. \nJika panjang AC = 9 cm, BC = 12 cm, dan BD = 20 cm, panjang AD adalah …',
                'image' => '/storage/soal/kuis1_nomor7.png',
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '15 cm',  'image' => null],
                'B' => ['text' => '20 cm',  'image' => null],
                'C' => ['text' => '25 cm',  'image' => null],
                'D' => ['text' => '30 cm', 'image' => null],
            ],

            'kunci_jawaban' => 'C'
        ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Perhatikan gambar berikut! \nPanjang BD adalah ….',
                'image' => '/storage/soal/kuis1_nomor8.png',
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '2 cm',  'image' => null],
                'B' => ['text' => '3 cm',  'image' => null],
                'C' => ['text' => '4 cm',  'image' => null],
                'D' => ['text' => '5 cm', 'image' => null],
            ],

            'kunci_jawaban' => 'C'
        ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Perhatikan gambar berikut! \nJika panjang BD = 12 cm, panjang AC adalah ….',
                'image' => '/storage/soal/kuis1_nomor9.png',
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '12 cm',  'image' => null],
                'B' => ['text' => '13 cm',  'image' => null],
                'C' => ['text' => '14 cm',  'image' => null],
                'D' => ['text' => '15 cm', 'image' => null],
            ],

            'kunci_jawaban' => 'A'
        ]);
        
        ButirSoal::create([
            'paket_soal_id' => 1,

            'pertanyaan' => [
                'text' => 'Nilai x yang memenuhi pada gambar di bawah adalah….',
                'image' => '/storage/soal/kuis1_nomor10.png',
            ],

            'opsi_jawaban' => [
                'A' => ['text' => '5',  'image' => null],
                'B' => ['text' => '6',  'image' => null],
                'C' => ['text' => '7',  'image' => null],
                'D' => ['text' => '8', 'image' => null],
            ],

            'kunci_jawaban' => 'A'
        ]);


    }

}
