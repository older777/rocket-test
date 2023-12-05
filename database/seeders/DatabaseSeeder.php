<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        // 'name' => 'Test User',
        // 'email' => 'test@example.com',
        // ]);
        if (! User::query()->get()->count()) {
            User::factory()->create([
                'name' => 'manager',
                'password' => Hash::make('123'),
                'role' => 1,
                'email' => 'local@localhost'
            ]);
        }
        if (! Category::query()->get()->count()) {
            Category::factory(10)->create();
        }
    }
}
