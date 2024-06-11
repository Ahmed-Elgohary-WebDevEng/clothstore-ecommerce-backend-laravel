<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAttribute extends Pivot
{
    use HasFactory;

    public $timestamps = null;
    protected $fillable = ['product_id', 'attribute_id'];
}
