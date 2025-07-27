<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class DinningStudent extends Model
{
    use TorkActivityLogTrait;
    protected $table = 'dinning_students';
    protected $guarded = [];


    // public function dinningMonths()
    // {
    //     return $this->hasMany(DinningMonth::class, 'dinning_student_id');
    // }

    public function scopeWithUser($query)
    {
        return $query->leftJoin('users', 'dinning_students.user_id', '=', 'users.id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeWithDinningMonth($query)
    {
        return $query->leftJoin('dinning_months', 'dinning_students.dinning_month_id', '=', 'dinning_months.id');
    }

    public function dinningMonth()
    {
        return $this->belongsTo(DinningMonth::class, 'dinning_month_id', 'id');
    }

    public function scopeWithDepartment($query)
    {
        return $query->leftJoin('departments', 'dinning_students.department_id', '=', 'departments.id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function scopeWithStudentSession($query)
    {
        return $query->leftJoin('student_sessions', 'dinning_students.student_session_id', '=', 'student_sessions.id');
    }

    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class, 'student_session_id', 'id');
    }




   

    public function refundRequests()
    {
        return $this->hasMany(RefundRequest::class, 'dinning_student_id');
    }
    //RELATIONAL METHOD









}
