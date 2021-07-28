<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get products
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
