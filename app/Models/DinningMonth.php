<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class DinningMonth extends Model
{
    use TorkActivityLogTrait;
    protected $table='dinning_months';
    protected $guarded = [];     
    
    
                            public function scopeWithUser($query)
                            {
                                return $query->leftJoin('users', 'dinning_months.user_id', '=', 'users.id');
                            }
                            
                        public function user()
                        {
                            return $this->belongsTo(User::class,'user_id','id');
                        }
                        
                            public function scopeWithDinningStudent($query)
                            {
                                return $query->leftJoin('dinning_students', 'dinning_months.dinning_student_id', '=', 'dinning_students.id');
                            }
                            
                        // public function dinningStudent()
                        // {
                        //     return $this->belongsTo(DinningStudent::class,'dinning_student_id','id');
                        // }
                        
                        public function dinningStudents()
                        {
                            return $this->hasMany(DinningStudent::class,'dinning_month_id');
                        }
                        public function refundRequests()
                        {
                            return $this->hasMany(RefundRequest::class, 'dinning_month_id');
                        }


                        //RELATIONAL METHOD
                        
                        
                            
                        
                            
}

?>
