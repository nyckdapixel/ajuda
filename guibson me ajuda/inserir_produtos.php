<?php
include("conexao.php");

// Defina os dados dos produtos (aqui você pode adicionar múltiplos produtos manualmente)
$produtos = [
    [
        'nome' => 'Ignite 8000 Usos - Vermelho',
        'descricao' => 'Cigarro eletrônico com 8000 sabores e 40% de desconto',
        'preco' => 49.90,
        'imagem' => 'cigarro1.jpg'
    ],
    [
        'nome' => 'Ignite 8000 Usos - Azul',
        'descricao' => 'Cigarro eletrônico com 8000 sabores e 40% de desconto',
        'preco' => 49.90,
        'imagem' => 'cigarro2.jpg'
    ],
    [
        'nome' => 'Ignite 8000 Usos - Amarelo',
        'descricao' => 'Cigarro eletrônico com 8000 sabores e 40% de desconto',
        'preco' => 49.90,
        'imagem' => 'cigarro3.jpg'
    ]
];

// Inserir cada produto no banco de dados
foreach ($produtos as $produto) {
    $nome = $produto['nome'];
    $descricao = $produto['descricao'];
    $preco = $produto['preco'];
    $imagem = $produto['imagem'];

    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $nome, $descricao, $preco, $imagem);

    if ($stmt->execute()) {
        echo "Produto '$nome' adicionado com sucesso!<br>";
    } else {
        echo "Erro ao adicionar o produto '$nome': " . $stmt->error . "<br>";
    }
}
?>
