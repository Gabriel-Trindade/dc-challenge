<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // Identificador único para a venda
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela customers
            $table->decimal('total', 10, 2); // Valor total da venda
            $table->enum('status', ['Pending', 'Completed', 'Cancelled'])->default('Pending'); // Status da venda
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}