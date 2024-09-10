<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_price',
    ];

    protected $table = 'products';

    // Define as relações
    public function itemSales()
    {
        return $this->hasMany(ItemSale::class);
    }
}
