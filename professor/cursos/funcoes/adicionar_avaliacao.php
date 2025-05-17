<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso negado.");
}

// Dados do formulário
$curso_id = (int) $_POST['curso_id'];
$titulo = trim($_POST['titulo']);
$tipo = $_POST['tipo'];
$descricao = trim($_POST['descricao']);

// Dados do professor logado
$criado_por_id = (int) $_SESSION['id'];
$tipo_criador = 'professor'; // fixo, já que é a aba de professor

// Validação
if (empty($titulo) || empty($tipo) || empty($descricao)) {
    die("Todos os campos são obrigatórios.");
}

// Verificar se já existe uma prova criada por esse professor para este curso
if ($tipo === 'Prova') {
    $sqlCheck = "SELECT id FROM avaliacoes 
                 WHERE curso_id = ? AND tipo = 'Prova' AND criado_por_id = ? AND tipo_criador = ?";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->bind_param("iis", $curso_id, $criado_por_id, $tipo_criador);
    $stmtCheck->execute();
    $resultadoCheck = $stmtCheck->get_result();

    if ($resultadoCheck->num_rows > 0) {
        // Redirecionar com mensagem de erro
        header("Location: ../ver_conteudo_curso.php?id=" . $curso_id . "&erro=ja_tem_prova");
        exit();
    }
}


// Inserção com criador e tipo
$sql = "INSERT INTO avaliacoes (curso_id, titulo, tipo, descricao, data_criacao, criado_por_id, tipo_criador)
        VALUES (?, ?, ?, ?, NOW(), ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("isssis", $curso_id, $titulo, $tipo, $descricao, $criado_por_id, $tipo_criador);

if ($stmt->execute()) {
    header("Location: ../ver_conteudo_curso.php?id=" . $curso_id);
    exit();
} else {
    echo "Erro ao cadastrar avaliação: " . $stmt->error;
}
