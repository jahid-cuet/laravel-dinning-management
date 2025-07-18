<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class Meal extends Model
{
    use TorkActivityLogTrait;
    protected $table='meals';
    protected $guarded = [];     
    
    
                            public function scopeWithDinningStudent($query)
                            {
                                return $query->leftJoin('dinning_students', 'meals.dinning_student_id', '=', 'dinning_students.id');
                            }
                            
                        public function dinningStudent()
                        {
                            return $this->belongsTo(DinningStudent::class,'dinning_student_id','id');
                        }
                        
                            public function scopeWithDinningMonth($query)
                            {
                                return $query->leftJoin('dinning_months', 'meals.dinning_month_id', '=', 'dinning_months.id');
                            }
                            
                        public function dinningMonth()
                        {
                            return $this->belongsTo(DinningMonth::class,'dinning_month_id','id');
                        }
                        //RELATIONAL METHOD
                        
                            
                        
                            
}

?>
