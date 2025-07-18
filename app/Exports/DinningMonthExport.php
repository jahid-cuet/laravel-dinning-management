<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class DinningMonthExport implements FromCollection, WithHeadings, WithMapping
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
            'title','meal_rate','from','to',
            'user_name',
            'dinning_student_name',
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
            $item->title,$item->meal_rate,$item->from,$item->to,
            $item?->user?->name,
            $item?->dinningStudent?->name,
            $item->is_active,
            $item->created_at,
            $item->updated_at,
        ];
    }
}