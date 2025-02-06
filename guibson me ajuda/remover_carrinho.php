<?php
session_start();
$conn = new mysqli('localhost', 'usuario', 'senha', 'loja_online');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $session_id = session_id();

    // Remover o produto do carrinho
    $sql = "DELETE FROM carrinho WHERE id = ? AND session_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $session_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: carrinho.php"); // Redireciona de volta para o carrinho
exit();
?>
