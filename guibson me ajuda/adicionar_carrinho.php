<?php
session_start();
include("conexao.php"); // Inclua sua conexão com o banco de dados

if(isset($_POST['adicionar'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade = 1; // Ou a quantidade que o usuário escolher
    $session_id = session_id(); // ID da sessão do usuário

    // Verifica se o produto já está no carrinho
    $sql = "SELECT * FROM carrinho WHERE produto_id = ? AND session_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $produto_id, $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Atualiza a quantidade do produto no carrinho
        $sql = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE produto_id = ? AND session_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $produto_id, $session_id);
    } else {
        // Adiciona o produto ao carrinho
        $sql = "INSERT INTO carrinho (produto_id, quantidade, session_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $produto_id, $quantidade, $session_id);
    }

    if($stmt->execute()) {
        echo "Produto adicionado ao carrinho!";
    } else {
        echo "Erro ao adicionar produto!";
    }
}
?>
