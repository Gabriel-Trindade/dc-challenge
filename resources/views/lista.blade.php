<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Vendas</title>
    <!-- Adicione aqui seus arquivos CSS, como Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-light py-3 border-bottom">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="m-0">Sistema de Vendas</h1>
            <a href="/" class="btn btn-primary">Nova venda</a>
        </div>
    </header>
    <div class="container">
        <h1 class="my-4">Listagem de Vendas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Subtotal</th>
                    <th>Data da Venda</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ number_format($sale->total, 2, ',', '.') }} R$</td>
                    <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-info btn-sm">Editar venda</a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar esta venda?')">Deletar venda</button>
                        </form>
                        <a href="{{ route('sales.pdf', $sale->id) }}" class="btn btn-warning btn-sm">Gerar PDF</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>