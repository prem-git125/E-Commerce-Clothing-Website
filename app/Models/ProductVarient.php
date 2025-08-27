<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVarient extends Model
{
    protected $fillable = [
        'product_id',
        'size_id',
        'price',
        'stock'
    ];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
