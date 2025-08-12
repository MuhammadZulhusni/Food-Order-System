<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Establishes a one-to-one relationship with the Client model.
    // The foreign key 'client_id' on this model links to the 'id' on the Client model.
    public function client(){
        return $this->belongsTo(Client::class, 'client_id','id');
    }
}