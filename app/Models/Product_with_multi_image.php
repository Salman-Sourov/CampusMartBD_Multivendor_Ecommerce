<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_with_multi_image extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table="product_with_multi_images";
    public function image_detail()
    {
        return $this->hasOne(Multi_image::class, 'id','multiImage_id');
    }
}
