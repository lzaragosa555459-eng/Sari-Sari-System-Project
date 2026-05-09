<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'brand_id',
        'category_id',
        'price',
        'expiration_date'
    ];
}
