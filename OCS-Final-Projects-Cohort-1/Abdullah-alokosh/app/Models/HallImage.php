<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallImage extends Model
{
    protected $fillable = ['hall_id', 'image_path', 'is_primary', 'sort_order'];

     public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
