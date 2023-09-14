<?php

namespace Database\Seeders;

use App\Models\Crawlsite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrawlsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Crawlsite::factory(10)->create();
    }
}
