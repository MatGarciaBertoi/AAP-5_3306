<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id'], $_SESSION['tipo'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: ../../login.php');
    exit;
}

// Verifica se o ID foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mensagem'] = 'Aula inválida.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: minhas_aulas.php');
    exit;
}

$id_aula = $_GET['id'];

// Buscar a aula
$sql = "
    SELECT a.id, a.titulo, a.conteudo, a.video_url, a.curso_id
    FROM aulas a
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ? AND c.criado_por_id = ? AND c.tipo_criador = ?
";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iis", $id_aula, $_SESSION['id'], $_SESSION['tipo']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['mensagem'] = 'Aula não encontrada ou acesso negado.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: minhas_aulas.php');
    exit;
}

$aula = $result->fetch_assoc();

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    $video_url = trim($_POST['video_url']);

    $update = $conexao->prepare("UPDATE aulas SET titulo = ?, conteudo = ?, video_url = ? WHERE id = ?");
    $update->bind_param("sssi", $titulo, $conteudo, $video_url, $id_aula);

    if ($update->execute()) {
        $_SESSION['mensagem'] = 'Aula atualizada com sucesso!';
        $_SESSION['mensagem_tipo'] = 'sucesso';
    } else {
        $_SESSION['mensagem'] = 'Erro ao atualizar aula.';
        $_SESSION['mensagem_tipo'] = 'erro';
    }

    header('Location: minhas_aulas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aula</title>
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/editar_aula.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<div class="container">
    <h1>Editar Aula</h1>
    <form method="POST">
        <label>Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($aula['titulo']) ?>" required>

        <label>Conteúdo:</label>
        <textarea name="conteudo" rows="6" required><?= htmlspecialchars($aula['conteudo']) ?></textarea>

        <label>URL do Vídeo:</label>
        <input type="url" name="video_url" value="<?= htmlspecialchars($aula['video_url']) ?>" required>

        <button type="submit">Salvar Alterações</button>
        <a href="minhas_aulas.php" class="btn-voltar">Cancelar</a>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>