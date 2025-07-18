<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class MonthlyMealDetail extends Model
{
    use TorkActivityLogTrait;
    protected $table='monthly_meal_details';
    protected $guarded = [];     
    
    
                            public function scopeWithUser($query)
                            {
                                return $query->leftJoin('users', 'monthly_meal_details.user_id', '=', 'users.id');
                            }
                            
                        public function user()
                        {
                            return $this->belongsTo(User::class,'user_id','id');
                        }
                        //RELATIONAL METHOD
                        
                            
}

?>
