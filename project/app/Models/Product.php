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
     * Get orders
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
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
