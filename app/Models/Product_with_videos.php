<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_with_videos extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table="product_with_videos";
}
