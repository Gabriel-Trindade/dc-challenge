<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'customer_id',
        'total',
        'status',
    ];

    // Define a tabela associada ao modelo
    protected $table = 'sales';

    // Define as relações
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function itemSales()
    {
        return $this->hasMany(ItemSale::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}