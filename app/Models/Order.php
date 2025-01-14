<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'orders';

    public function product()
    {
        return $this->hasMany(Order_product::class,'order_id', 'id')->with('product_details');
    }

    
    

}
