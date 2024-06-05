<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'product_slug',
        'SKU',
        'regular_price',
        'discount_price',
        'quantity',
        'description',
        'product_weight',
        'product_note',
        'published',
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}
