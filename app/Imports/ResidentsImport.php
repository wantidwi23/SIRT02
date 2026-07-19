<?php

namespace App\Imports;

use App\Models\Resident;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ResidentsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Get nama from either 'nama' or 'nama_lengkap' column
        $nama = $row['nama'] ?? $row['nama_lengkap'] ?? null;
        
        // Skip if nama is empty
        if (empty($nama)) {
            return null;
        }

        // Get email - required field
        $email = $row['email'] ?? null;
        if (empty($email)) {
            return null;
        }

        // Get alamat from either 'alamat' or 'address' column
        $alamat = $row['alamat'] ?? $row['address'] ?? null;
        if (empty($alamat)) {
            return null;
        }

        return new Resident([
            'name'     => $nama,
            'gender'   => $row['jenis_kelamin'] ?? $row['gender'] ?? null,
            'email'    => $email,
            'address'  => $alamat,
            'status'   => $row['status'] ?? 'active',
            'notes'    => $row['catatan'] ?? $row['notes'] ?? null,
        ]);
    }
}
