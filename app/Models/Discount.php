<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    public function tour(){
        return $this->belongsTo(Tour::class,'tour_id','id');
    }
    public function cate(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
