<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(ProductSeeder::class);

        User::factory()->create([
            'name' => 'Dzaki Yushiibanaa',
            'email' => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $this->call([
            CategorySeeder::class,
        ]);
    }
}
