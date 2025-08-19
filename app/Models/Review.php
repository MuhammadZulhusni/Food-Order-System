<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    // Disable mass assignment protection for all fields.
    protected $guarded = [];

    /**
     * Define a many-to-one relationship with the Client model.
     * A review belongs to a single client.
     */
    public function client(){
        return $this->belongsTo(Client::class, 'client_id','id');
    }

    /**
     * Define a many-to-one relationship with the User model.
     * A review belongs to a single user.
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}