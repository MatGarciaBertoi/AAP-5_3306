<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    die("Acesso negado.");
}

$avaliacao_id = isset($_GET['avaliacao_id']) ? (int) $_GET['avaliacao_id'] : 0;

$sql = "SELECT * FROM avaliacoes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $avaliacao_id);
$stmt->execute();
$result = $stmt->get_result();
$avaliacao = $result->fetch_assoc();

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Avaliação</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Editar Avaliação</h1>
        <form action="funcoes/atualizar_avaliacao.php" method="POST">
            <input type="hidden" name="id" value="<?= $avaliacao['id'] ?>">
            <input type="hidden" name="curso_id" value="<?= $avaliacao['curso_id'] ?>">

            <label for="titulo">Título:</label><br>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($avaliacao['titulo']) ?>" required><br><br>

            <label for="tipo">Tipo:</label><br>
            <select name="tipo" id="tipo" required>
                <option value="Prova" <?= $avaliacao['tipo'] == 'Prova' ? 'selected' : '' ?>>Prova</option>
                <option value="Atividade" <?= $avaliacao['tipo'] == 'Atividade' ? 'selected' : '' ?>>Atividade</option>
            </select><br><br>

            <label for="descricao">Descrição:</label><br>
            <textarea name="descricao" id="descricao" rows="5" required><?= htmlspecialchars($avaliacao['descricao']) ?></textarea><br><br>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>

</html>