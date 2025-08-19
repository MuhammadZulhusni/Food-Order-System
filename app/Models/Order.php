<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Defines a one-to-one relationship with the User model.
     *
     * This method establishes that the current model belongs to a single User,
     * using the 'user_id' as the foreign key.
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }

    /**
     *
     * This method establishes a **one-to-many relationship**, indicating that a single instance
     * of the current model (e.g., an `Order`) can have many `OrderItem` instances.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function OrderItems(){
        return $this->hasMany(OrderItem::class, 'order_id','id');
    }
}