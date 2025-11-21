<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ⭐ Tambahan penting: average rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png'); // fallback jika tidak ada
        }

        // Jika sudah URL lengkap (http/https)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Jika tersimpan di storage lokal
        return asset('storage/' . $this->image);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }


}
