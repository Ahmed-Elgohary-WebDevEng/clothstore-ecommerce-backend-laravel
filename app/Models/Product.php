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

    // Product Belong to Many Attributes
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, ProductAttribute::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id');
    }

    // ********** Local Scopes **************
    // Filter Product
    public function scopeFilter($query, array $filters): void
    {
        // filter by category slug
        $query->when($filters['category'] ?? false, function (Builder $query, $category) {
            $query->whereHas('category.parent', function (Builder $query) use ($category) {
                $query->where('slug', $category);
            });
        });

        // filter by subcategory
        $query->when($filters['sub_category'] ?? false, function (Builder $query, $sub_category) {
            $query->whereHas('category', function (Builder $query) use ($sub_category) {
                $query->where('slug', $sub_category);
            });
        });

        // filter by min price
        $query->when($filters['min'] ?? false, function (Builder $query, $min) {
            $query->where('regular_price', '>=', $min);
        });


        // filter by max price
        $query->when($filters['max'] ?? false, function (Builder $query, $max) {
            $query->where('regular_price', '<=', $max);
        });

        // sorting
        $query->when($filters['sort'] ?? false, function (Builder $query, $sort) {
            switch ($sort) {
                case "asc price":
                    $query->orderBy('regular_price', 'asc');
                    break;

                case "desc price":
                    $query->orderBy('regular_price', 'desc');
                    break;
                case "asc lastupdated":

                    $query->orderBy('created_at', 'asc');
                    break;
                case "desc lastupdated":
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        });
    }

}
