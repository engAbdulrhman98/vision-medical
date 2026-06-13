<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'details',
        'price',
        'image',
        'in_stock',
    ];

    protected $casts = [
        'in_stock' => 'boolean',
        'price' => 'decimal:2',
    ];

    public $translatable = ['name', 'description', 'details'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function averageRating()
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }
}
