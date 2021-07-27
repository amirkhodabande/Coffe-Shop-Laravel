<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKey()
    {
        return "slug";
    }

    /**
     * Get information about the sale of this product.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the number of sales
     *
     * @return int
     */
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }
}
