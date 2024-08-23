<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::factory()->count(3)->sequence(
            ['name' => 'Admin'],
            ['name' => 'Moderator'],
            ['name' => 'Sales'],
        )->create();

        User::factory()->create([
            'name' => 'Muneeb',
            'email' => 'muneeb@nexvistech.com',
            'password' => bcrypt('1qaz2wsx'),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role_id' => 1,
        ]);

        Brand::factory()->count(5)->create();
        ProductCategory::factory()->count(20)->create();
    }
}
