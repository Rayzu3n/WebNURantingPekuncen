<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD');

        if (! is_string($password) || trim($password) === '') {
            throw new RuntimeException(
                'ADMIN_PASSWORD must be set in your .env file before running database seeders.'
            );
        }

        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrator'),
                'password' => $password,
                'role' => 'admin',
            ]
        );

        // Keep an existing password unchanged when seeding again.
        $changes = [];

        if ($admin->name !== env('ADMIN_NAME', 'Administrator')) {
            $changes['name'] = env('ADMIN_NAME', 'Administrator');
        }

        if ($admin->role !== 'admin') {
            $changes['role'] = 'admin';
        }

        if ($changes !== []) {
            $admin->forceFill($changes)->save();
        }
    }
}
