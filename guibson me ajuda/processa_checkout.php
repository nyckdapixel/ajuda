<?php


// Obter as informações do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

$nome_titular = $_POST['nome-titular'];
$numero_cartao = $_POST['numero-cartao'];
$validade_cartao = $_POST['validade-cartao'];
$cvv_cartao = $_POST['cvv-cartao'];

// Verificar se os dados do cartão são obrigatórios (se o pagamento for por cartão)
if (isset($_POST['payment']) && $_POST['payment'] == 'cartao') {
    if (empty($nome_titular) || empty($numero_cartao) || empty($validade_cartao) || empty($cvv_cartao)) {
        die("Erro: Dados do cartão não podem estar vazios.");
    }
}

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "if0_38254033_onavapes";  // Substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inserir dados na tabela de 'cartao_credito'
$sql = "INSERT INTO cartao_credito (usuario_id, numero_cartao, validade_cartao, cvv_cartao, nome_titular)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $usuario_id, $numero_cartao, $validade_cartao, $cvv_cartao, $nome_titular);

if ($stmt->execute()) {
    // Redirecionar para ok.html em caso de sucesso
    header("Location: ok.html");
    exit();  // Certifique-se de usar o exit() após o header para parar a execução do código
} else {
    echo "Erro ao processar o pedido: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>