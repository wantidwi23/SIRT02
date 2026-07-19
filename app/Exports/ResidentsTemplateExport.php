<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResidentsTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        return [
            [
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'laki-laki',
                'email' => 'budi@gmail.com',
                'alamat' => 'Jl. Merdeka No. 123, RT 01/RW 02',
                'status' => 'active',
                'catatan' => 'Contoh catatan warga',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'jenis_kelamin' => 'perempuan',
                'email' => 'siti@gmail.com',
                'alamat' => 'Jl. Sudirman No. 45',
                'status' => 'active',
                'catatan' => '',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Jenis Kelamin',
            'Email',
            'Alamat',
            'Status',
            'Catatan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']],
            ],
        ];
    }
}
