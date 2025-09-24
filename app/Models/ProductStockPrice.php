<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockPrice extends Model
{
    protected $fillable = [
        'product_id',
        'product_varient_id',
        'price',
        'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVarient()
    {
        return $this->belongsTo(ProductVarient::class);
    }
}
