<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a "Russell Jones" user
        User::factory()->create([
            'name' => 'Russell Jones',
            'email' => 'russell@example.com', // Change this to the desired email
            'password' => bcrypt('password'),
        ]);

        // Uncomment the following lines if you want to create more users
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed other data using other seeders
        $this->call([
            CrawlsiteSeeder::class,
        ]);
    }
}
