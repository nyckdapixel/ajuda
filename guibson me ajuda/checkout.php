<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja_vape";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $pagamento = $_POST['payment'];

    // Se o pagamento for via cartão, coletar os dados do cartão
    $numero_cartao = null;
    $validade_cartao = null;
    $cvv_cartao = null;
    if ($pagamento == 'cartao') {
        $numero_cartao = $_POST['numero_cartao'];
        $validade_cartao = $_POST['validade_cartao'];
        $cvv_cartao = $_POST['cvv_cartao'];
    }

    // Usando prepared statements para evitar SQL injection
    $stmt = $conn->prepare("INSERT INTO pedidos (nome, cpf, email, telefone, endereco, cidade, estado, cep, pagamento, numero_cartao, validade_cartao, cvv_cartao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $nome, $cpf, $email, $telefone, $endereco, $cidade, $estado, $cep, $pagamento, $numero_cartao, $validade_cartao, $cvv_cartao);

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Pedido realizado com sucesso!";
        header("Location: ok.html"); // Redireciona para a página de confirmação
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Ona Vape</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            background: #1c1c1c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 255, 255, 0.3);
            gap: 40px;
            margin: 20px;
        }

        .form-section, .cart-section {
            flex: 1;
            min-width: 300px;
            padding: 30px;
            background: #2c2c2c;
            border-radius: 12px;
        }

        h2, h3 {
            color: #00ffcc;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-section input, .form-section select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #444;
            background: #333;
            color: white;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-section input:focus, .form-section select:focus {
            border-color: #00ffcc;
            outline: none;
        }

        .payment-methods {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
        }

        .payment-methods label {
            flex: 1;
            padding: 14px;
            background: #444;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s;
        }

        .payment-methods input:checked + label {
            background: #00ffcc;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: #ffcc00;
            color: black;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 25px;
            border: none;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #00ffcc;
        }

        .cart-items {
            margin-top: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            background: #333;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .cart-info {
            flex: 1;
        }

        .cart-info h4 {
            color: #00ffcc;
            font-size: 20px;
        }

        .cart-info p {
            color: #ccc;
            font-size: 16px;
            margin-top: 5px;
        }

        #pix-info {
            display: none;
            margin-top: 20px;
            background: #000000;
            padding: 20px;
            border-radius: 10px;
        }

        #cartao-info {
            display: none;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="form-section">
            <h2>Finalizar Compra</h2>
            <form action="checkout.php" method="POST">
                <input type="text" name="nome" placeholder="Nome Completo" required>
                <input type="text" name="cpf" placeholder="CPF" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="text" name="telefone" placeholder="Telefone" required>
                <input type="text" name="endereco" placeholder="Endereço" required>
                <input type="text" name="cidade" placeholder="Cidade" required>
                <select name="estado" required>
                    <option value="" disabled selected>Estado</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <!-- outros estados -->
                </select>
                <input type="text" name="cep" placeholder="CEP" required>

                <h3>Forma de Pagamento</h3>
                <div class="payment-methods">
                    <label>
                        <input type="radio" name="payment" value="pix" required> PIX
                    </label>
                    <label>
                        <input type="radio" name="payment" value="cartao" required> Cartão
                    </label>
                </div>

                <div id="cartao-info">
                    <input type="text" name="numero_cartao" placeholder="Número do Cartão" maxlength="16">
                    <input type="text" name="validade_cartao" placeholder="Validade (MM/AA)">
                    <input type="text" name="cvv_cartao" placeholder="CVV" maxlength="3">
                </div>

                <button type="submit" class="checkout-btn">Finalizar Compra</button>
            </form>

            <div id="pix-info">
                <p><strong>Para pagar via PIX, faça o pagamento no link abaixo e envie o comprovante para o número 97981189151:</strong></p>
                <p><a href="https://livepix.gg/vakinhasolidaria" target="_blank">livepix.gg/vakinhasolidaria</a></p>
            </div>
        </div>
    </div>

    <script>
        // Mostrar Campos do Cartão de Crédito quando a opção for escolhida
        document.querySelector('input[name="payment"][value="cartao"]').addEventListener('change', function() {
            document.getElementById('cartao-info').style.display = 'block';
            document.getElementById('pix-info').style.display = 'none';
        });

        document.querySelector('input[name="payment"][value="pix"]').addEventListener('change', function() {
            document.getElementById('cartao-info').style.display = 'none';
            document.getElementById('pix-info').style.display = 'block';
        });
    </script>
</body>
</html>
