<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'color',
    'icon','status'];
    public function halls() {
    return $this->belongsToMany(Hall::class, 'category_hall');
}

}
