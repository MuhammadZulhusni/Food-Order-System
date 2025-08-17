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
}