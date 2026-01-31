<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallService extends Model
{
    protected $fillable = [
        'hall_id',
        'name',
        'category',
        'price',
        'description',
        'image_path',
        'video_path',
        'is_active'
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
