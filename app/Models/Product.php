<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Define the relationship to the Menu model.
     * A Product belongs to a single Menu.
     */
    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id','id');
    }

    /**
     * Get the client that owns the product.
     */
    public function client(){
        return $this->belongsTo(Client::class, 'client_id','id');
    }

    /** Establishes a one-to-one relationship with the City model.
    * The foreign key 'city_id' on this model links to the 'id' on the City model.
    */
    public function city(){
        return $this->belongsTo(City::class, 'city_id','id');
    }
}