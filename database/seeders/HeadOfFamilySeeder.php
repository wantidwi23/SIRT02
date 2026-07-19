<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeadOfFamily::create([
            'nama' => 'Budi Hartono',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'alamat' => 'Jl. Merdeka No. 123',
            'active' => true,
        ]);

        HeadOfFamily::create([
            'nama' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'alamat' => 'Jl. Sudirman No. 456',
            'active' => true,
        ]);
    }
}
