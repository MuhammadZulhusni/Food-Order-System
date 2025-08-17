<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Defines a one-to-one relationship with the Product model.
     *
     * This method indicates that the current model belongs to a single Product.
     * The relationship is established using the 'product_id' foreign key.
     */
    public function product(){
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}