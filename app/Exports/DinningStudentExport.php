<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class DinningStudentExport implements FromCollection, WithHeadings, WithMapping
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
            'student_id','name','txid','total_meals','from','to','paid_status',
            'user_name',
            'dinning_month_title',
            'department_name',
            'student_session_name',
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
            $item->student_id,$item->name,$item->txid,$item->total_meals,$item->from,$item->to,$item->paid_status,
            $item?->user?->name,
            $item?->dinningMonth?->title,
            $item?->department?->name,
            $item?->studentSession?->name,
            $item->is_active,
            $item->created_at,
            $item->updated_at,
        ];
    }
}