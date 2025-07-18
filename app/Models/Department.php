<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class Department extends Model
{
    use TorkActivityLogTrait;
    protected $table='departments';
    protected $guarded = [];     
    
    
                        public function dinningStudents()
                        {
                            return $this->hasMany(DinningStudent::class,'department_id');
                        }
                        //RELATIONAL METHOD
                        
}

?>
