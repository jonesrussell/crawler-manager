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
        $canadianNewsWebsites = [
            ['title' => 'CBC News', 'url' => 'https://www.cbc.ca/'],
            ['title' => 'CTV News', 'url' => 'https://www.ctvnews.ca/'],
            ['title' => 'Global News', 'url' => 'https://globalnews.ca/'],
            ['title' => 'The Globe and Mail', 'url' => 'https://www.theglobeandmail.com/'],
            ['title' => 'National Post', 'url' => 'https://nationalpost.com/'],
            // Add more websites here
        ];

        // Create Crawlsite records for the Canadian news websites
        foreach ($canadianNewsWebsites as $website) {
            Crawlsite::create($website);
        }
    }
}
