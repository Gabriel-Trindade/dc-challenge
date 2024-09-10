<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'name',
        'cpf',
    ];

    // Define a tabela associada ao modelo
    protected $table = 'customers';

    // Define as relações
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

