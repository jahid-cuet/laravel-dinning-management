<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class RefundMeal extends Model
{
    use TorkActivityLogTrait;
    protected $table='refund_meals';
    protected $guarded = [];     
    
    
                            public function scopeWithRefundRequest($query)
                            {
                                return $query->leftJoin('refund_requests', 'refund_meals.refund_request_id', '=', 'refund_requests.id');
                            }
                            
                        public function refundRequest()
                        {
                            return $this->belongsTo(RefundRequest::class,'refund_request_id','id');
                        }
                        //RELATIONAL METHOD
                        
                            
}

?>
