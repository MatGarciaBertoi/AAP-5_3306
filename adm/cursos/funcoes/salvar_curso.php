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

    $nome = trim($_POST['nome-curso'] ?? '');
    $categoria = $_POST['categoria'] ?? '';
    $descricao = trim($_POST['descricao'] ?? '');
    $dificuldade = $_POST['dificuldade'] ?? '';
    $criado_por_id = $_SESSION['id'];
    $tipo_criador = $_SESSION['tipo'];

    $categorias_permitidas = [
        'Marketing de Afiliados',
        'Marketing de Conteúdo',
        'E-mail Marketing',
        'Social Media',
        'Análise de Marketing',
        'SEO',
        'Tráfego Pago'
    ];

    $dificuldades_permitidas = ['iniciante', 'intermediario', 'avancado'];

    if (empty($nome) || empty($categoria) || empty($descricao) || empty($dificuldade)) {
        $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../cursos.php");
        exit;
    }

    if (!in_array($categoria, $categorias_permitidas) || !in_array($dificuldade, $dificuldades_permitidas)) {
        $_SESSION['mensagem'] = "Categoria ou dificuldade inválida.";
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

    // Define diretório de destino da imagem
    $diretorio_relativo = '../../../funcoes/uploads/cursos/';
    $diretorio_absoluto = realpath($diretorio_relativo);

    if (!$diretorio_absoluto) {
        if (!mkdir($diretorio_relativo, 0755, true)) {
            $_SESSION['mensagem'] = "Falha ao criar diretório de upload.";
            $_SESSION['mensagem_tipo'] = "erro";
            header("Location: ../cursos.php");
            exit;
        }
        $diretorio_absoluto = realpath($diretorio_relativo);
    }

    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid('curso_') . "." . $extensao;
    $caminho_destino = $diretorio_absoluto . '/' . $imagem_nome;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_destino)) {
        $_SESSION['mensagem'] = "Falha ao enviar a imagem.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../cursos.php");
        exit;
    }

    // Caminho a ser salvo no banco (relativo ao projeto)
    $caminho_imagem_no_banco = 'funcoes/uploads/cursos/' . $imagem_nome;

    $sql = "INSERT INTO cursos (nome, categoria, descricao, imagem, dificuldade, criado_por_id, tipo_criador) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssis", $nome, $categoria, $descricao, $caminho_imagem_no_banco, $dificuldade, $criado_por_id, $tipo_criador);

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
