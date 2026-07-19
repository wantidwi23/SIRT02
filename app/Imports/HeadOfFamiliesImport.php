<?php

namespace App\Imports;

use App\Models\HeadOfFamily;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class HeadOfFamiliesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Create User entry
        User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['nama'],
                'password' => Hash::make($row['password']),
                'role' => 'user',
                'active' => $row['active'] ?? true,
            ]
        );

        // Create HeadOfFamily entry
        return new HeadOfFamily([
            'nama'     => $row['nama'],
            'alamat'   => $row['alamat'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
            'active'   => $row['active'] ?? true,
        ]);
    }
}
