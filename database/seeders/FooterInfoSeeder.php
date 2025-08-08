<?php

namespace Database\Seeders;

use App\Models\FooterInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterInfo::insert([


                'short_info' => 'There are many variations of Lorem Ipsum available, but the majority have suffered.',
                'address' => '7232 El-Minia 308, Alamir Heights, 11372, NY, Egypt',
                'phone' => '0106 9100 892',
                'email' => 'ahmedalamir521@gmail.com',
                'copyright' => 'Copyright © 2025 Alamir. All Rights Reserved',
                'created_at' => now(),
                'updated_at' => now(),

        ]);
    }
}
