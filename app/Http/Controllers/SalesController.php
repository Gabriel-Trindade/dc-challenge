<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ItemSale;
use App\Models\Installment;
use App\Models\Payment;
use Illuminate\Http\Request;
use PDF;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::get();
        return view('lista', compact('sales'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_items' => 'required|array',
            'sale_items.*.product_id' => 'required|exists:products,id',
            'sale_items.*.quantity' => 'required|integer|min:1',
            'sale_items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment.type' => 'required|in:avista,parcelado',
            'payment.amount' => 'required_if:payment.type,avista|numeric|min:0',
            'payment.installments' => 'array|required_if:payment.type,parcelado',
            'payment.installments.*.amount' => 'required_if:payment.type,parcelado|numeric|min:0',
            'payment.installments.*.due_date' => 'required_if:payment.type,parcelado|date',
        ]);

        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'total' => $request->total,
            'status' => 'Pending',
        ]);

        foreach ($request->sale_items as $item) {
            ItemSale::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);
        }

        if ($request->payment['type'] === 'avista') {
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $request->payment['amount'],
                'payment_type' => 'avista',
            ]);
        } else if ($request->payment['type'] === 'parcelado') {
            foreach ($request->payment['installments'] as $installment) {
                Installment::create([
                    'sale_id' => $sale->id,
                    'amount' => $installment['amount'],
                    'due_date' => $installment['due_date'],
                ]);
                //Pensei na tabela de pagamento muito a frente como se fosse em produção nesse caso, como não haverá um pagamento real, 
                //então as parcelas se tornam pagamento!
                Payment::created([
                    'sale_id' => $sale->id,
                    'amount' => $installment['amount'],
                    'due_date' => $installment['due_date']
                ]);
            }
        }

        return response()->json($sale);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_items' => 'required|array',
            'sale_items.*.product_id' => 'required|exists:products,id',
            'sale_items.*.quantity' => 'required|integer|min:1',
            'sale_items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment.type' => 'required|in:avista,parcelado',
            'payment.amount' => 'required_if:payment.type,avista|numeric|min:0',
            'payment.installments' => 'array|required_if:payment.type,parcelado',
            'payment.installments.*.amount' => 'required_if:payment.type,parcelado|numeric|min:0',
            'payment.installments.*.due_date' => 'required_if:payment.type,parcelado|date',
        ]);

        $sale = Sale::findOrFail($id);

        // Atualiza os detalhes da venda
        $sale->update([
            'customer_id' => $request->customer_id,
            'total' => $request->total,
            'status' => 'Pending',
        ]);

        // Atualiza os itens da venda
        foreach ($request->input('sale_items') as $item) {
            $itemSale = ItemSale::find($item['id']);
            if ($itemSale) {
                $itemSale->update($item);
            }
        }

        // Atualiza os pagamentos
        if ($request->payment_type == 'avista') {
            $sale->payments()->update([
                'amount' => $request->avista_amount,
                'due_date' => now(),
            ]);
        } elseif ($request->payment_type == 'parcelado') {
            foreach ($request->input('due_dates') as $index => $dueDate) {
                $payment = Payment::find($request->input('payment_ids')[$index]);
                if ($payment) {
                    $payment->update([
                        'due_date' => $dueDate,
                        'amount' => $request->input('amounts')[$index],
                    ]);
                }
            }
        }
    }

    public function generatePDF($id)
    {
        $sale = Sale::with('customer', 'itemSales.product')->findOrFail($id);

        $pdf = PDF::loadView('sales.pdf', compact('sale'));
        return $pdf->download('venda_' . $sale->id . '.pdf');
    }

    public function edit($id)
    {
        $sale = Sale::with(['itemSales', 'customer', 'payments'])->findOrFail($id);
        $products = Product::all();
        $selectedProducts = $sale->itemSales->pluck('product_id');

        return view('sales.edit', [
            'sale' => $sale,
            'products' => $products,
            'customer' => $sale->customer,
            'selectedProducts' => $selectedProducts
        ]);
    }
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda deletada com sucesso!');
    }
}
