<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_category;
use App\Models\Product_category_product;

class Product_category_transletion extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table="product_category_products";

    public function products()
    {
        return $this->hasMany(Product_category::class, 'category_id');
    }

    public function category_detail()
    {
        return $this->hasOne(Product_category_transletion::class, 'id','category_id');
    }
}
