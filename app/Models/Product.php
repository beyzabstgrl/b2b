<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use  SoftDeletes,HasFactory;

    protected $fillable = [
        'name', 'sku', 'price', 'stock_quantity'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
