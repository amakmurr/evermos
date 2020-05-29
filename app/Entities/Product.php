<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'price', 'stock'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }
}
