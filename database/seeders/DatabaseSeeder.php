<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'syafiqqhalimm92@gmail.com',
            'ic_no' => '920416025327',
            'no_phone' => '0137933604',
            'role' => 'superadmin',
            'status' => 'active',
            'password' => bcrypt('12345678'),
        ]);
    }
}
