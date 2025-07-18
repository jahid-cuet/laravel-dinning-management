<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class StudentSession extends Model
{
    use TorkActivityLogTrait;
    protected $table='student_sessions';
    protected $guarded = [];     
    
    
                        public function dinningStudents()
                        {
                            return $this->hasMany(DinningStudent::class,'student_session_id');
                        }
                        //RELATIONAL METHOD
                        
}

?>
