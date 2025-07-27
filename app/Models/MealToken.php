<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class MealToken extends Model
{
    use TorkActivityLogTrait;
    protected $table='meal_tokens';
    protected $guarded = [];     
    
    
                            public function scopeWithDinningStudent($query)
                            {
                                return $query->leftJoin('dinning_students', 'meal_tokens.dinning_student_id', '=', 'dinning_students.id');
                            }
                            
                        public function user()
                        {
                            return $this->belongsTo(DinningStudent::class,'user_id','id');
                        }
                        //RELATIONAL METHOD
                        
                            
}

?>
