<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'brands';

    public function translations()
    {
        return $this->hasOne(Brand_translation::class, 'brand_id');
    }

}
