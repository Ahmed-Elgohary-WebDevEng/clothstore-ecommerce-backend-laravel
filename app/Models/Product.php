<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected static function booted(): void
    {
        static::addGlobalScope('images', function (Builder $builder) {
            $builder->with('images');
        });
    }

    /**
     * Product Relations
     */

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Gallary::class, 'product_id');
    }

    // Many to Many
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
    }


    // One to Many
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id');
    }
}
