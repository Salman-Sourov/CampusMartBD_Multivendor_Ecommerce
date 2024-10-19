<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_attribute;

class Product_with_attribute_set extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'product_with_attribute_sets';
    
    public function attributes()
    {
        return $this->hasOne(product_attribute::class, 'attribute_set_id', 'id');
    }
}


