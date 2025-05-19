<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    die("Acesso negado.");
}

$aula_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Buscar a aula
$sql = "SELECT * FROM aulas WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $aula_id);
$stmt->execute();
$result = $stmt->get_result();
$aula = $result->fetch_assoc();

if (!$aula) {
    die("Aula não encontrada.");
}

// Atualizar aula
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $video_url = $_POST['video_url'];

    $sqlUpdate = "UPDATE aulas SET titulo = ?, conteudo = ?, video_url = ? WHERE id = ?";
    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $titulo, $conteudo, $video_url, $aula_id);

    if ($stmtUpdate->execute()) {
        header("Location: ver_conteudo_curso.php?id=" . $aula['curso_id']);
        exit;
    } else {
        echo "Erro ao atualizar a aula.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Aula</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/editar_aula.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h2>Editar Aula</h2>
        <form method="POST">
            <label for="titulo">Título:</label><br>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($aula['titulo']) ?>" required><br><br>

            <label for="conteudo">Conteúdo:</label><br>
            <textarea name="conteudo" id="conteudo" rows="6" required><?= htmlspecialchars($aula['conteudo']) ?></textarea><br><br>

            <label for="video_url">URL do Vídeo:</label><br>
            <input type="text" name="video_url" id="video_url" value="<?= htmlspecialchars($aula['video_url']) ?>"><br><br>

            <button type="submit">Salvar Alterações</button>

        </form>
    </div>
</body>

</html>