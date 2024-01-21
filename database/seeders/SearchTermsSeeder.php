<?php

namespace Database\Seeders;

use App\Models\SearchTerm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SearchTermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $popularSearchTerms = [
            'Apple',
            'Google',
            'Microsoft',
            'Facebook',
            'Twitter',
            'Instagram',
            'Amazon',
            'Netflix',
            'Spotify',
            'Uber',
            'Tesla',
            'SpaceX',
            'Elon Musk',
            'Bitcoin',
            'Cryptocurrency',
            'Artificial Intelligence',
            'Machine Learning',
            'Data Science',
            'Blockchain',
            'Climate Change'
        ];

        foreach ($popularSearchTerms as $term) {
            SearchTerm::create([
                'term' => $term,
            ]);
        }
    }
}
