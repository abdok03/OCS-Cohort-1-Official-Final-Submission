<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    /** @use HasFactory<\Database\Factories\HallFactory> */
    use HasFactory;
        protected $fillable = [
        'name','slug','description','capacity_min','capacity_max','price_per_day',
        'price_per_hour','address','city','status','user_id',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories() {
    return $this->belongsToMany(Category::class, 'category_hall');
}
public function images()
{
    return $this->hasMany(HallImage::class);
}
public function primaryImage()
{
    return $this->hasOne(HallImage::class)->where('is_primary', true);
}
public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
