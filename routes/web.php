<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Rota para a tela de vendas
Route::get('/', function () {
    return view('venda'); 
});


// Rota para a listagem de vendas
Route::get('/lista', [SalesController::class, 'index'])->name('sales.index');

// Rotas para CRUD de clientes
Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');

// Rotas para CRUD de produtos
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');

// Rota para criar uma nova venda
Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');;
// Rota para exibir o formulário de edição de uma venda
Route::get('/sales/{id}/edit', [SalesController::class, 'edit'])->name('sales.edit');
Route::put('/sales/{id}', [SalesController::class, 'update'])->name('sales.update');
Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
Route::get('/sales/{id}/pdf', [SalesController::class, 'generatePDF'])->name('sales.pdf');