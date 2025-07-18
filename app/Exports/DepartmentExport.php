<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepartmentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    
    //***custom heading****
    public function headings():array{
        return[
            'id',
            'name','code',
            'Is Active',
            'Created At',
            'Updated At',
    ];
    }


    //****mapping data****
    public function map($item): array
    {
        return [
            $item->id,
            $item->name,$item->code,
            $item->is_active,
            $item->created_at,
            $item->updated_at,
        ];
    }
}