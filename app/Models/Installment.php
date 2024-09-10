<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'sale_id',
        'amount',
        'due_date',
    ];

    // Define a tabela associada ao modelo
    protected $table = 'installments';

    // Define as relações
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}