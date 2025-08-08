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
}