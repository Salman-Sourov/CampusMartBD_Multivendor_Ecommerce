<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_attribute_set extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'product_attribute_sets';
}
