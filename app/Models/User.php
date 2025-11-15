<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Admin;       

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke produk (jika vendor)
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    // Relasi ke order (jika customer)
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // Relasi ke review (jika customer)
    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
