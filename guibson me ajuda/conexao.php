<?php
// conexao.php
$servername = "localhost"; // Altere para o seu servidor de banco de dados
$username = "root"; // Altere para o seu usuário
$password = ""; // Altere para a sua senha
$dbname = "nome_do_banco"; // Altere para o nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
