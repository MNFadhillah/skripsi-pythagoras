<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $badges = [
            // Kategori Materi
            [
                'name' => 'Pythagoras Explorer',
                'description' => 'Berhasil menyelesaikan materi Menemukan Konsep Teorema Pythagoras.',
                'image_path' => 'pythagoras_explorer.png'
            ],
            [
                'name' => 'Tripel Hunter',
                'description' => 'Berhasil menyelesaikan materi Tripel Pythagoras.',
                'image_path' => 'tripel_hunter.png'
            ],
            [
                'name' => 'Specialist',
                'description' => 'Berhasil menyelesaikan materi Segitiga Istimewa.',
                'image_path' => 'specialist.png'
            ],
            [
                'name' => 'The Executioner',
                'description' => 'Berhasil menyelesaikan materi Penerapan Teorema Pythagoras.',
                'image_path' => 'the_executioner.png'
            ],

            [
                'name' => 'Pythalearn Master',
                'description' => 'Luar Biasa! Telah menyelesaikan 100% seluruh materi, kuis, dan evaluasi.',
                'image_path' => 'pythalearn_master.png'
            ]
        ];

        // Looping untuk memasukkan data ke database
        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}