<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vendas</title>
    <!-- Adicione os links e scripts necessários para o Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-light py-3 border-bottom">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="m-0">Sistema de Vendas</h1>
            <a href="{{ route('sales.index') }}" class="btn btn-primary">Ver Lista de Vendas</a>
        </div>
    </header>
    <div class="container">
        <h1 class="my-4">Criar Venda</h1>
        <form id="sale-form">
            <section id="sale">
                <!-- Campos do Formulário de Vendas -->
                <div class="form-group">
                    <label for="customer">Cliente</label>
                    <select id="customer" class="form-control" name="customer">
                        <option value="">Escolha um Cliente</option>
                    </select>
                    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#customerModal">Cadastrar Cliente</button>
                </div>
                <div class="form-group">
                    <label for="products">Produtos</label>
                    <select id="products" class="form-control">
                        <option value="">Escolha um produto...</option>
                    </select>
                    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#productModal">Cadastrar Produto</button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>CPF</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="customer-info">

                    </tbody>
                </table>

                <!-- Tabela de Itens da Venda -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="sale-items">
                        <!-- Itens serão adicionados aqui -->
                    </tbody>
                </table>

                <!-- Botão Salvar Venda -->
                <button type="button" id="save-sale" class="btn btn-success">Salvar Venda</button>
            </section>

            <!-- Seção de Pagamento -->
            <section id="payment">
                <!-- Botão Editar Venda -->
                <button type="button" id="edit-sale" class="btn btn-warning" style="display: none;">Editar Venda</button>
                <!-- Exibe o total -->
                <div class="form-group">
                    <label for="total-price">Subtotal Total: </label>
                    <span id="total-price">0.00</span> <!-- Aqui será exibido o subtotal total -->
                </div>

                <div class="form-group">
                    <label for="payment-type">Forma de Pagamento</label>
                    <select id="payment-type" class="form-control">
                        <option value="">Escolha a Forma de Pagamento</option>
                        <option value="avista">À Vista</option>
                        <option value="parcelado">Parcelado</option>
                    </select>
                </div>

                <!-- Tabela de Pagamento à Vista (inicialmente escondida) -->
                <div id="avista-payment" style="display: none;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Forma de Pagamento</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pagamento Único</td>
                                <td><input type="number" id="avista-amount" class="form-control" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Seção para Parcelamento (inicialmente escondida) -->
                <div id="parcelado-payment" style="display: none;">
                    <div class="form-group">
                        <label for="num-parcelas">Número de Parcelas</label>
                        <input type="number" id="num-parcelas" class="form-control" min="1" max="12">
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Parcela</th>
                                <th>Data de Pagamento</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody id="parcelas-info">
                            <!-- Parcelas serão geradas aqui -->
                        </tbody>
                    </table>
                </div>
                <button type="submit" id="finishButton" class="btn btn-success">Finalizar Pedido</button>
            </section>
        </form>

        <!-- Modal para Cadastro de Cliente -->
        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerModalLabel">Cadastrar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="clientForm">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                        <div id="clientMessage" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Cadastro de Produto -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Cadastrar Produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="productForm">
                            @csrf
                            <div class="form-group">
                                <label for="product-name">Nome</label>
                                <input type="text" id="product-name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="unit_price">Valor Unitário</label>
                                <input type="number" id="unit_price" name="unit_price" class="form-control" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar Produto</button>
                        </form>
                        <div id="productMessage" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            // Carregar clientes na inicialização
            loadCustomers();
            loadProducts();

            function loadCustomers() {
                $.ajax({
                    url: "{{ route('customers.index') }}", // Substitua com a rota que retorna a lista de clientes
                    method: 'GET',
                    success: function(response) {
                        var $select = $('#customer');
                        $select.empty(); // Limpar opções existentes
                        $select.append('<option value="">Escolha um Cliente</option>');

                        // Adiciona os clientes ao select
                        $.each(response.customers, function(index, customer) {
                            var option = $('<option>', {
                                value: customer.id,
                                text: customer.name
                            });

                            // Atribui o CPF usando .data()
                            option.data('cpf', customer.cpf);
                            $select.append(option);
                        });
                    },
                    error: function(xhr) {
                        console.error('Erro ao carregar clientes.');
                    }
                });
            }

            function loadProducts() {
                $.ajax({
                    url: "{{ route('products.index') }}", // Rota para buscar produtos
                    method: 'GET',
                    success: function(response) {
                        var $select = $('#products');
                        $select.empty(); // Limpar opções existentes
                        $select.append('<option value="">Escolha um produto...</option>'); // Adiciona opção padrão

                        // Adiciona os produtos ao select
                        $.each(response.products, function(index, product) {
                            var option = $('<option>', {
                                value: product.id,
                                text: product.name
                            });

                            // Atribui o preço usando .data()
                            option.data('price', product.unit_price);
                            $select.append(option);
                        });
                    },
                    error: function(xhr) {
                        console.error('Erro ao carregar produtos.');
                    }
                });
            }

            // Ao selecionar um cliente, adicionar à tabela
            $('#customer').on('change', function() {
                var selectedCustomer = $(this).find(':selected');
                var customerId = selectedCustomer.val();
                var customerName = selectedCustomer.text();
                var customerCPF = selectedCustomer.data('cpf'); // Recupera o CPF do cliente

                // Se houver um cliente selecionado, adiciona à tabela
                if (customerId) {
                    addCustomerToTable(customerId, customerName, customerCPF);
                }
            });

            function addCustomerToTable(customerId, customerName, customerCPF) {
                var $customerInfoTable = $('#customer-info');

                // Verificar se já existe um cliente na tabela
                if ($customerInfoTable.find('tr').length > 0) {
                    alert('Apenas um cliente pode ser adicionado por pedido.');
                    return;
                }

                // HTML da nova linha da tabela
                var newRow = `
        <tr data-customer-id="${customerId}">
            <td>${customerName}</td>
            <td>${customerCPF}</td>
            <td><button class="btn btn-danger remove-item">Remover Cliente</button></td>
        </tr>
    `;

                // Adiciona a nova linha à tabela
                $customerInfoTable.append(newRow);
            }

            // Função para remover cliente da tabela
            $('#customer-info').on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
            });

            // Ao selecionar um produto, adicionar à tabela
            $('#products').on('change', function() {
                var selectedProduct = $(this).find(':selected');
                var productId = selectedProduct.val();
                var productName = selectedProduct.text();
                var productPrice = selectedProduct.data('price'); // Recupera o preço correto

                // Se houver um produto selecionado, adiciona à tabela
                if (productId) {
                    addProductToTable(productId, productName, productPrice);
                }
            });

            function addProductToTable(productId, productName, productPrice) {
                var $saleItems = $('#sale-items');

                // Verificar se o produto já foi adicionado à tabela
                if ($saleItems.find('tr[data-product-id="' + productId + '"]').length > 0) {
                    alert('Este produto já foi adicionado.');
                    return;
                }

                // HTML da nova linha da tabela
                var newRow = `
        <tr data-product-id="${productId}">
            <td>${productName}</td>
            <td><input type="number" class="form-control quantity" value="1" min="1" /></td>
            <td><input type="number" class="form-control unit-price" value="${productPrice}" min="0" step="0.01" /></td>
            <td class="subtotal">${productPrice}</td>
            <td><button class="btn btn-danger remove-item">Remover</button></td>
        </tr>
    `;

                // Adiciona a nova linha à tabela
                $saleItems.append(newRow);

                // Atualiza o subtotal ao alterar quantidade ou valor unitário
                updateSubtotals();
            }

            // Função para atualizar o subtotal ao alterar quantidade ou valor unitário
            function updateSubtotals() {
                $('#sale-items').on('input', '.quantity, .unit-price', function() {
                    var $row = $(this).closest('tr');
                    var quantity = $row.find('.quantity').val();
                    var unitPrice = $row.find('.unit-price').val();
                    var subtotal = (quantity * unitPrice).toFixed(2); // Calcula o subtotal com 2 casas decimais
                    $row.find('.subtotal').text(subtotal);

                });
            }

            // Remover produto da tabela
            $('#sale-items').on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
            });


            $('#clientForm').on('submit', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('customers.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#clientMessage').html('<div class="alert alert-success">Cliente cadastrado com sucesso!</div>');
                        // Opcional: atualizar lista de clientes na página ou no modal
                        $('#clientModal').modal('hide');
                        // Limpar formulário
                        $('#clientForm')[0].reset();

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        $('#clientMessage').html('<div class="alert alert-danger">Erro ao cadastrar cliente.</div>');
                    }
                });
            });

            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('products.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#productMessage').html('<div class="alert alert-success">O produto foi cadastrado com sucesso!</div>');
                        $('#productModal').modal('hide');
                        $('#productForm')[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        $('#productMessage').html('<div class="alert alert-danger">Erro ao cadastrar o produto.</div>');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#payment').hide();
            // Quando o botão Salvar Venda for clicado
            $('#save-sale').on('click', function() {
                // Desabilitar os campos de cliente, produtos e tabelas
                $('#customer').prop('disabled', true);
                $('#products').prop('disabled', true);
                $('#customerModal').prop('disabled', true);
                $('#productModal').prop('disabled', true);
                $('#customer-info input, #customer-info button').prop('disabled', true);
                $('#sale-items input, #sale-items button').prop('disabled', true);

                // Mostrar botão de editar venda e esconder botão de salvar venda
                $('#edit-sale').show();
                $('#save-sale').hide();

                // Mostrar a seção de pagamento e habilitar os campos de pagamento
                $('#payment').show();
            });

            // Quando o botão Editar Venda for clicado
            $('#edit-sale').on('click', function() {
                // Habilitar os campos de cliente, produtos e tabelas
                $('#customer').prop('disabled', false);
                $('#products').prop('disabled', false);
                $('#customerModal').prop('disabled', false);
                $('#productModal').prop('disabled', false);
                $('#customer-info input, #customer-info button').prop('disabled', false);
                $('#sale-items input, #sale-items button').prop('disabled', false);

                // Mostrar botão de salvar venda e esconder botão de editar venda
                $('#save-sale').show();
                $('#edit-sale').hide();

                // Esconder a seção de pagamento
                $('#payment').hide();
            });

            // Quando o tipo de pagamento for alterado
            $('#payment-type').on('change', function() {
                var paymentType = $(this).val();

                if (paymentType === 'avista') {
                    $('#avista-payment').show();
                    $('#parcelado-payment').hide();
                } else if (paymentType === 'parcelado') {
                    $('#avista-payment').hide();
                    $('#parcelado-payment').show();
                } else {
                    $('#avista-payment').hide();
                    $('#parcelado-payment').hide();
                }
            });
        });
    </script>

    <script>
        $('#save-sale').on('click', function() {
            // Função para calcular o subtotal total
            function calculateTotal() {
                var total = 0;

                $('#sale-items .subtotal').each(function() {
                    var itemSubtotal = parseFloat($(this).text()) || 0; // Converte o valor para número
                    total += itemSubtotal; // Soma ao total
                });

                return total.toFixed(2); // Retorna o total com 2 casas decimais
            }

            // Inicializa o valor total e armazena para uso posterior
            var total = calculateTotal();

            // Atualiza o subtotal total na seção de pagamento parcelado
            $('#total-price').text(total);

            // Função para atualizar os valores das parcelas
            function updateParcelaValues() {
                var totalParcelaSum = 0;
                var parcelas = $('#parcelas-info tr');
                var numParcelas = parcelas.length;

                // Calcula a soma dos valores das parcelas, exceto a última
                parcelas.each(function(index, row) {
                    if (index < numParcelas - 1) {
                        var $valorInput = $(row).find('.valor-parcela');
                        var valorParcela = parseFloat($valorInput.val()) || 0;
                        totalParcelaSum += valorParcela;
                    }
                });

                // Calcula o valor da última parcela
                var lastParcela = numParcelas > 0 ? (total - totalParcelaSum).toFixed(2) : 0;
                if (numParcelas > 0) {
                    $('#parcelas-info tr').last().find('.valor-parcela').val(lastParcela);
                }
            }

            // Quando o tipo de pagamento for alterado
            $('#payment-type').on('change', function() {
                var paymentType = $(this).val();

                if (paymentType === 'avista') {
                    // Exibir tabela de pagamento à vista
                    $('#avista-payment').show();
                    $('#parcelado-payment').hide();

                    // Colocar o valor total na tabela à vista
                    $('#avista-amount').val(total);
                } else if (paymentType === 'parcelado') {
                    // Exibir tabela de parcelamento
                    $('#avista-payment').hide();
                    $('#parcelado-payment').show();

                    // Atualiza o total nas parcelas
                    $('#total-price').text(total); // Exibe o total na seção de parcelamento
                } else {
                    // Se nenhuma opção for escolhida, esconder ambas as tabelas
                    $('#avista-payment').hide();
                    $('#parcelado-payment').hide();
                }
            });

            // Quando o número de parcelas for alterado
            $('#num-parcelas').on('change', function() {
                numParcelas = parseInt($(this).val());
                var $parcelasInfo = $('#parcelas-info');
                $parcelasInfo.empty(); // Limpar parcelas anteriores

                if (numParcelas && numParcelas > 0) {
                    var parcelaValor = (total / numParcelas).toFixed(2);

                    for (var i = 1; i <= numParcelas; i++) {
                        var disabled = i === numParcelas ? 'disabled' : '';
                        var newRow = `
                <tr>
                    <td>Parcela ${i}</td>
                    <td><input type="date" class="form-control data-parcela" required></td>
                    <td><input type="number" class="form-control valor-parcela" value="${i < numParcelas ? parcelaValor : parcelaValor}" min="1" ${disabled} required></td>
                </tr>
            `;

                        $parcelasInfo.append(newRow);
                    }

                    // Atualizar os valores das parcelas quando alterado
                    $('.valor-parcela').on('input', updateParcelaValues);
                }
            });

            // Inicializa a função para definir o valor da última parcela
            $('#num-parcelas').trigger('change');

        });
    </script>
    <script>
        $('#finishButton').on('click', function(e) {
            e.preventDefault();

            // Função para calcular o subtotal total
            function calculateTotal() {
                var total = 0;

                $('#sale-items .subtotal').each(function() {
                    var itemSubtotal = parseFloat($(this).text()) || 0; // Converte o valor para número
                    total += itemSubtotal; // Soma ao total
                });

                return total.toFixed(2); // Retorna o total com 2 casas decimais
            }

            // Verificar se há um cliente selecionado
            if ($('#customer-info tr').length === 0) {
                alert('Selecione um cliente.');
                return;
            }

            // Verificar se há pelo menos um produto adicionado
            if ($('#sale-items tr').length === 0) {
                alert('Adicione pelo menos um produto.');
                return;
            }

            // Obter dados do cliente
            var customerId = $('#customer-info tr').data('customer-id');

            // Obter dados dos produtos
            var saleItems = [];
            $('#sale-items tr').each(function() {
                var productId = $(this).data('product-id');
                var quantity = $(this).find('.quantity').val();
                var unitPrice = $(this).find('.unit-price').val();
                var subtotal = $(this).find('.subtotal').text();

                if (productId && quantity && unitPrice && subtotal) {
                    saleItems.push({
                        product_id: productId,
                        quantity: quantity,
                        price: unitPrice,
                        subtotal: subtotal
                    });
                }
            });

            // Verificar se há dados de itens
            if (saleItems.length === 0) {
                alert('Adicione pelo menos um item à venda.');
                return;
            }

            // Obter dados de pagamento
            var paymentType = $('#payment-type').val();
            var paymentData = {};
            if (paymentType === 'avista') {
                paymentData = {
                    type: paymentType,
                    amount: $('#avista-amount').val()
                };
            } else if (paymentType === 'parcelado') {
                var installments = [];
                $('#parcelas-info tr').each(function() {
                    var installmentAmount = $(this).find('.valor-parcela').val();
                    var installmentDate = $(this).find('.data-parcela').val();

                    if (installmentAmount && installmentDate) { // Verificar se os valores das parcelas estão preenchidos
                        installments.push({
                            amount: installmentAmount,
                            due_date: installmentDate
                        });
                    }
                });

                if (installments.length === 0) {
                    alert('Adicione pelo menos uma parcela.');
                    return;
                }

                paymentData = {
                    type: paymentType,
                    installments: installments
                };
            } else {
                alert('Selecione um tipo de pagamento.');
                return;
            }

            // Enviar os dados para o controller
            $.ajax({
                url: "{{ route('sales.store') }}", // Substitua com a rota que vai processar a venda
                method: 'POST',
                data: {
                    customer_id: customerId,
                    sale_items: saleItems,
                    total: calculateTotal(), // Inclui o total da venda
                    payment: paymentData,
                    _token: $('meta[name="csrf-token"]').attr('content') // Inclui o token CSRF
                },
                success: function(response) {
                    // Sucesso na operação
                    alert('Venda finalizada com sucesso!');
                    // Limpar o formulário após o sucesso
                    $('#sale-form')[0].reset();
                    $('#sale-items').empty();
                    $('#customer-info').empty();
                    $('#payment').hide();
                    $('#save-sale').show();
                    $('#edit-sale').hide();
                },
                error: function(xhr) {
                    // Erro na operação
                    alert('Erro ao finalizar a venda.');
                    console.error(xhr.responseText); // Para depuração
                }
            });
        });
    </script>
</body>

</html>