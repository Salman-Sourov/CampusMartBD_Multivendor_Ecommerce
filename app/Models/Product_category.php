<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Product_category;

use App\Models\Product_category_transletion;


class Product_category extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'product_categories';

    public function translations()
    {
        return $this->hasOne(Product_category_transletion::class, 'categories_id')->where('lang_code','bn');
    }

    public function hasChild()
    {
        return $this->hasMany(Product_category::class,'parent_id','id');
    }
    public function totalProduct()
    {
        return $this->hasOne(Product_category_product::class,'category_id');
    }
    
    public function subcategory()
    {
        return $this->hasOne(Product_category::class, 'id','category_id');
    }
}
