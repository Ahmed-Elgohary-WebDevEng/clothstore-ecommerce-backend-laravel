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
        // search by name
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('personal_info', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        });

        // search by department
        $query->when($filters['depart'] ?? false, function ($query, $department) {
            $query->where('department_id', $department);
        });

        // search by gender
        $query->when($filters['gender'] ?? false, function ($query, $gender) {
            $query->whereHas('personal_info', function ($query) use ($gender) {
                $query->where('gender', $gender);
            });
        });
    }

}
