<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_product_attribute extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'order_product_attributes';
}
