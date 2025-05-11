<?php
session_start();

require_once '../funcoes/conexao.php';

$cursoId = $_GET['curso_id'] ?? null;

if (!$cursoId) {
    echo "Curso não encontrado.";
    exit;
}

// Consulta os dados do curso no banco
$stmt = $conexao->prepare("SELECT * FROM cursos WHERE id = ?");
$stmt->bind_param("i", $cursoId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Curso não encontrado.";
    exit;
}

$curso = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($curso['nome']) ?> - Detalhes do Curso</title>
    <link rel="stylesheet" href="css/detalhes.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>

    <main class="curso-detalhes">
        <div class="container">
            <h2><?= htmlspecialchars($curso['nome']) ?></h2>

            <?php if (!empty($curso['imagem'])): ?>
                <img src="../professor/cursos/funcoes/uploads/<?= htmlspecialchars($curso['imagem']) ?>" alt="Imagem do curso" class="img-curso">
            <?php endif; ?>

            <p><strong>Categoria:</strong> <?= htmlspecialchars($curso['categoria']) ?></p>
            <p><strong>Dificuldade:</strong> <?= htmlspecialchars($curso['dificuldade']) ?></p>
            <p><strong>Descrição:</strong><br><?= nl2br(htmlspecialchars($curso['descricao'])) ?></p>

            <form action="funcoes/inscrever_curso.php" method="POST">
                <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
                <button type="submit" class="btn-assinar">Inscrever-se</button>
            </form>
        </div>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>