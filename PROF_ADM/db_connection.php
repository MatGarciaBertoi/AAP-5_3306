<?php
$servername = "localhost";
$username = "root"; // Seu nome de usuário do MySQL
$password = ""; // Sua senha do MySQL
$dbname = "aapcw_cadastro"; // Nome do banco de dados

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificação da conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
