<?php
header('Content-Type: application/json');

include_once '../../funcoes/conexao.php';  // Ajuste o caminho para o arquivo de conexão

// Consulta os cursos no banco
$query = "SELECT id, nome, categoria FROM cursos ORDER BY nome ASC";
$result = $conexao->query($query);

$cursos = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cursos[] = [
            'id' => $row['id'],
            'nome' => $row['nome'],
            'categoria' => $row['categoria'],
            'link' => "detalhes_curso.php?curso_id=" . $row['id']  // Aqui a alteração
        ];
    }
}

echo json_encode($cursos);
