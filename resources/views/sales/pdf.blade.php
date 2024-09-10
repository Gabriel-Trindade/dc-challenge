<h1>Detalhes da Venda #{{ $sale->id }}</h1>
<p>Cliente: {{ $sale->customer->name }}</p>
<p>Data: {{ $sale->created_at->format('d/m/Y') }}</p>
<h3>Itens Vendidos</h3>
<ul>
    @foreach($sale->itemSales as $item)
        <li>{{ $item->product->name }} - Quantidade: {{ $item->quantity }} - Preço: {{ number_format($item->unit_price, 2, ',', '.') }} R$</li>
    @endforeach
</ul>
<p>Total: {{ number_format($sale->total, 2, ',', '.') }} R$</p>
