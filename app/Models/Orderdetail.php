<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'orderdetails_id';
    public function tour(){
        return $this->belongsTo(Tour::class,'tour_id','id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_code','order_code');
    }
    public function coupon(){
        return $this->belongsTo(Voucher::class,'voucher','voucher_code');
    }
}
