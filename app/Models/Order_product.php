<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'order_products';

    public function product_details(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
