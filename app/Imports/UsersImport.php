<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldQueue;
class UsersImport implements ToModel, WithHeadingRow, ShouldQueue
{
    public function collection()
    {
        return User::select('id', 'role_id', 'full_name', 'phone')->get();
    }

    public function headings(): array
    {
        return ['ID', 'role_id', 'full_name', 'phone'];
    }
}
