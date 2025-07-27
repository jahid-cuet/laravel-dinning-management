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
                            
                        public function user()
                        {
                            return $this->belongsTo(User::class,'user_id','id');
                        }
                        
                        public function refundMeals()
                        {
                            return $this->hasMany(RefundMeal::class,'refund_request_id');
                        }


                        public function meals()
                        {
                            return $this->hasMany(Meal::class,'refund_request_id');
                        }


                        public function dinningMonth()
                        {
                            return $this->belongsTo(DinningMonth::class, 'dinning_month_id', 'id');
                        }
                                            //RELATIONAL METHOD
                        
                        
                            
}