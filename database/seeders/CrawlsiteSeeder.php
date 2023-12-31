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
            ['title' => 'CP24 News', 'url' => 'https://www.cp24.com/news', 'searchTerms' => 'prescription,gang,drug,JOINT,CANNABI,IMPAIR,SHOOT,FIREARM,MURDER,COCAIN,POSSESS'],
            ['title' => 'CBC News', 'url' => 'https://www.cbc.ca/', 'searchTerms' => 'gang,drugs,cocaine,fentanyl,meth'],
            ['title' => 'CTV News', 'url' => 'https://www.ctvnews.ca/', 'searchTerms' => 'news,Canada'],
            ['title' => 'Global News', 'url' => 'https://globalnews.ca/', 'searchTerms' => 'news,Canada'],
            ['title' => 'The Globe and Mail', 'url' => 'https://www.theglobeandmail.com/', 'searchTerms' => 'news,Canada'],
            ['title' => 'National Post', 'url' => 'https://nationalpost.com/', 'searchTerms' => 'news,Canada'],
        ];

        // Create Crawlsite records for the Canadian news websites
        foreach ($canadianNewsWebsites as $website) {
            Crawlsite::create($website);
        }
    }
}
