<?php
include_once('../../funcoes/sessoes/check_aluno.php');
include_once('../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

if (!isset($_GET['curso_id'])) {
    echo "Curso não especificado.";
    exit();
}

$curso_id = intval($_GET['curso_id']);
$aluno_id = $_SESSION['id'];

// Verifica se o aluno está inscrito nesse curso
$sql = "SELECT c.* FROM cursos c 
        INNER JOIN inscricoes i ON i.curso_id = c.id 
        WHERE i.aluno_id = ? AND c.id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Você não está inscrito neste curso.";
    exit();
}

$curso = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($curso['nome']); ?></title>
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/abacursos.css">
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">
        <h1><?= htmlspecialchars($curso['nome']); ?></h1>
        <?php if (!empty($curso['imagem'])): ?>
            <img src="../../<?= htmlspecialchars($curso['imagem']); ?>" alt="Imagem do curso">
        <?php endif; ?>

        <p><strong>Descrição do curso:</strong></p>
        <p><?= nl2br(htmlspecialchars($curso['descricao'])); ?></p>

        <a href="ver_conteudo.php?curso_id=<?= $curso_id ?>">📘 Ver Conteúdo</a>
        <a href="../areadoaluno.php">🔙 Voltar para seus cursos</a>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>