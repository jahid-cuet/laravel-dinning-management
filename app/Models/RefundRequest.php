<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class RefundRequest extends Model
{
    use TorkActivityLogTrait;
    protected $table='refund_requests';
    protected $guarded = [];     
    
    
                            public function scopeWithDinningStudent($query)
                            {
                                return $query->leftJoin('dinning_students', 'refund_requests.dinning_student_id', '=', 'dinning_students.id');
                            }
                            
                        public function dinningStudent()
                        {
                            return $this->belongsTo(DinningStudent::class,'dinning_student_id','id');
                        }
                        
                        public function refundMeals()
                        {
                            return $this->hasMany(RefundMeal::class,'refund_request_id');
                        }
                        //RELATIONAL METHOD
                        
                        
                            
}