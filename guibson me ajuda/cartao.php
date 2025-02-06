<?php
session_start();
$conn = new mysqli('localhost', 'usuario', 'senha', 'loja_online');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['nome'], $_POST['email'], $_POST['cpf'], $_POST['card-number'], $_POST['expiry-date'], $_POST['cvv'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $card_number = $_POST['card-number']; // IDEALMENTE DEVE SER CRIPTOGRAFADO
    $expiry_date = $_POST['expiry-date'];
    $cvv = $_POST['cvv']; // IDEALMENTE DEVE SER CRIPTOGRAFADO

    // Inserir cliente e dados do cartão
    $sql = "INSERT INTO clientes (nome_completo, email, cpf, cartao_numero, cartao_validade, cartao_cvv) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $email, $cpf, $card_number, $expiry_date, $cvv);
    $stmt->execute();
    $stmt->close();
}

echo "Compra finalizada com sucesso!";
?>
