<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VariantAttributeValue extends Pivot
{
    use HasFactory;

    public $timestamps = null;

    protected $fillable = [
        'attribute_id',
        'variant_id'
    ];
}
