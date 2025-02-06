-- Criar banco de dados (se necessário)
CREATE DATABASE IF NOT EXISTS onavapes;
USE onavapes;

-- Tabela de usuários (assumindo que você tenha uma tabela de usuários)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(15),
    endereco VARCHAR(255),
    cidade VARCHAR(100),
    estado VARCHAR(100),
    cep VARCHAR(10)
);

-- Tabela de cartões de crédito
CREATE TABLE IF NOT EXISTS cartao_credito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    numero_cartao VARCHAR(16) NOT NULL, -- Número do cartão (será criptografado)
    validade_cartao VARCHAR(5) NOT NULL, -- Validade no formato MM/AA
    cvv_cartao VARCHAR(3) NOT NULL, -- CVV
    nome_titular VARCHAR(100) NOT NULL, -- Nome do titular do cartão
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
