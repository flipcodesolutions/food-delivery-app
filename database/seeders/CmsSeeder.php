<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cms;
use Carbon\Carbon;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        Cms::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'description' => 'This is the about us page description.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Cms::create([
            'title' => 'Terms and Conditions',
            'slug' => 'terms-and-conditions',
            'description' => 'This is the terms and conditions page description.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Cms::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'description' => 'This is the privacy policy page description.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

         Cms::create([
            'title' => 'Refund Policy',
            'slug' => 'refund-policy',
            'description' => 'This is the refund policy page description.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}