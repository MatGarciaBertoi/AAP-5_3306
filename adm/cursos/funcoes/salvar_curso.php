<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    $_SESSION['mensagem'] = "Acesso negado. Faça login.";
    $_SESSION['mensagem_tipo'] = "erro";
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome-curso'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $dificuldade = $_POST['dificuldade'] ?? '';
    $criado_por_id = $_SESSION['id'];
    $tipo_criador = $_SESSION['tipo'];

    if (empty($nome) || empty($categoria) || empty($descricao) || empty($dificuldade)) {
        $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../cursos.php");
        exit;
    }

    if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['mensagem'] = "Imagem é obrigatória.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../cursos.php");
        exit;
    }

    $tipo_mime = mime_content_type($_FILES['imagem']['tmp_name']);
    if (!in_array($tipo_mime, ['image/jpeg', 'image/png', 'image/gif'])) {
        $_SESSION['mensagem'] = "Tipo de imagem inválido. Envie JPEG, PNG ou GIF.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../cursos.php");
        exit;
    }

    if (!is_dir(__DIR__ . '/uploads')) {
        mkdir(__DIR__ . '/uploads', 0755, true);
    }

    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid('curso_') . "." . $extensao;
    $caminho_destino = __DIR__ . '/uploads/' . $imagem_nome;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_destino)) {
        $_SESSION['mensagem'] = "Falha ao enviar a imagem.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../cursos.php");
        exit;
    }

    $sql = "INSERT INTO cursos (nome, categoria, descricao, imagem, dificuldade, criado_por_id, tipo_criador) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssis", $nome, $categoria, $descricao, $imagem_nome, $dificuldade, $criado_por_id, $tipo_criador);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Curso criado com sucesso!";
        $_SESSION['mensagem_tipo'] = "sucesso";
    } else {
        $_SESSION['mensagem'] = "Erro ao salvar o curso: " . $stmt->error;
        $_SESSION['mensagem_tipo'] = "erro";
    }

    $stmt->close();
    $conexao->close();

    header("Location: ../cursos.php");
    exit;
} else {
    $_SESSION['mensagem'] = "Requisição inválida.";
    $_SESSION['mensagem_tipo'] = "erro";
    header("Location: ../cursos.php");
    exit;
}
