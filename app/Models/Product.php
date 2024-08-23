<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sort',
        'model',
        'price',
        'image',
        'banner',
        'points',
        'status',
        'trending',
        'subtract',
        'quantity',
        'brand_id',
        'short_url',
        'min_quantity',
        'description'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id')->withTimestamps();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
