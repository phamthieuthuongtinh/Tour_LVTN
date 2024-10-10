<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $primaryKey = 'comment_id';
    public function tour(){
        return $this->belongsTo(Tour::class, 'comment_tour_id', 'id');
    }
 
}
