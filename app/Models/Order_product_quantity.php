<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_product_quantity extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'order_product_quantities';
}
