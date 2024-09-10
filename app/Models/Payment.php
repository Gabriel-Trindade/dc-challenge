<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'sale_id',
        'amount',
        'payment_type',
    ];

    // Define a tabela associada ao modelo
    protected $table = 'payments';

    // Define as relações
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}