<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HeadOfFamiliesTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        return [
            // Example row
            [       
                'nama' => 'Contoh Nama',
                'alamat' => 'Jl. Contoh No. 123',
                'email' => 'contoh@gmail.com',
                'password' => 'password123',
                'active' => 1,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'alamat',
            'email',
            'password',
            'active',
        ];
    }
}
