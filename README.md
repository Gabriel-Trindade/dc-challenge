
# Sales Management System

Este é um sistema de gerenciamento de vendas desenvolvido com Laravel.

## Requisitos

- PHP ^8.0
- Composer
- MySQL


## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/Gabriel-Trindade/dc-challenge.git
   cd dc-challenge
   ```

2. Instale as dependências do PHP:
   ```bash
   composer install
   ```

3. Configure o arquivo `.env` com as informações do banco de dados.

4. Execute as migrações:
   ```bash
   php artisan migrate
   ```

## Executando o Projeto

Inicie o servidor:
```bash
php artisan serve
```

Agora, acesse [http://localhost:8000](http://localhost:8000).

## Geração de PDF

Este projeto usa **Barryvdh DomPDF**. Use o botão "Gerar PDF" na interface de listagem de vendas.

## Funcionalidades

O projeto consegue perfomar o basico do challenge, conseguindo cadastrar uma venda, listar, editar e deletar e como um pequeno extra, gerar pdf de uma venda.

## Licença

Licenciado sob a [MIT License](https://opensource.org/licenses/MIT).
