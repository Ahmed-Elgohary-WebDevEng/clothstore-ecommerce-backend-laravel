<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_name',
        'attribute_value',
        'color'
    ];

    // Many to Many
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute');
    }

    // many to many
    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class, 'attribute_variant');
    }
}
