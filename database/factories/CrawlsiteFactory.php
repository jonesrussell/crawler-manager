<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crawlsite>
 */
class CrawlsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $searchTerms = implode(',', $this->faker->words(5));

        return [
            'title' => $this->faker->sentence,
            'url' => $this->faker->url,
            'searchTerms' => $searchTerms,
        ];
    }
}
