<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'products';

    public function translations()
    {
        return $this->hasOne(product_translation::class, 'products_id');
    }
    public function categories()
    {
        return $this->hasOne(product_category_product::class,  'product_id', 'id')->with(['category_detail']);
    }
    public function brands()
    {
        return $this->hasOne(brand::class, 'id', 'brand_id');
    }
    public function multi_images()
    {
        return $this->hasMany(Product_with_multi_image::class,  'product_id', 'id')->with(['image_detail']);
    }
    public function videos()
    {
        return $this->hasMany(Product_with_videos::class, 'product_id', 'id')->with(['video_detail']);
    }
    public function attribute_set()
    {
        return $this->hasOne(Product_with_attribute_set::class, 'product_id', 'id')->with(['attributes']);
    }
    public function inventory_stocks()
    {
        return $this->hasMany(Product_attribute_wise_stock::class, 'product_id', 'id')->with(['inventory_details']);
    }
}
