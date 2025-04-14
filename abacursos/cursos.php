<?php
// Conexão com o banco de dados principal
$conn = new mysqli('localhost', 'root', '', 'aapcw_cadastro'); // Banco principal

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar os cursos com imagem e vídeo
$sql = "SELECT nome_curso AS titulo, descricao, imagem, video_url FROM cursos";
$result = $conn->query($sql);

$cursos = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
}

// Retorna os dados em formato JSON
echo json_encode($cursos);

$conn->close();
?>
