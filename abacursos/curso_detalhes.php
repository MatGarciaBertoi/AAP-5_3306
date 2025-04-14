<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'aapcw_cadastro'; // Banco principal

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$sql = "SELECT id, nome_curso AS titulo, descricao, imagem, video_url FROM cursos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $curso = $result->fetch_assoc();
    echo json_encode($curso);
} else {
    echo json_encode([]);
}

$conn->close();
?>
