<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSale extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price', // Valor unitário do produto na venda
        'subtotal', // Quantidade * Preço
    ];

    // Define a tabela associada ao modelo
    protected $table = 'items_sales';

    // Define as relações
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}