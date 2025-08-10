<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = [];


    // Establishes a one-to-many relationship with the Product model.
    // This method indicates that a single instance of the current model can have many associated Product models.
    public function products(){
        return $this->hasMany(Product::class);
    }
}