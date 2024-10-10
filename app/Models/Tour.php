<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'business_id', 'id');
    }
    public function departures()
    {
        return $this->hasMany(Departure::class);
    }
}
