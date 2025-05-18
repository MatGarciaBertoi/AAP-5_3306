<?php
include_once('../funcoes/sessoes/check_aluno.php');
include_once('../funcoes/conexao.php');

$aluno_id = $_SESSION['id'];

$stmt = $conexao->prepare(
    "SELECT cc.data_conclusao, c.nome AS nome_curso, c.id AS curso_id 
     FROM cursos_concluidos cc 
     JOIN cursos c ON c.id = cc.curso_id 
     WHERE cc.aluno_id = ?"
);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Certificados - CW Cursos</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/abatrofeus.css">
    <link rel="stylesheet" href="partials/style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>🎓 Meus Certificados</h1>

        <div class="gallery">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="certificate">
                        <h2><?= htmlspecialchars($row['nome_curso']); ?></h2>
                        <p>Concluído em: <?= date('d/m/Y', strtotime($row['data_conclusao'])); ?></p>
                        <form action="abacursos/gerar_certificado.php" method="POST" target="_blank">
                            <input type="hidden" name="curso_id" value="<?= $row['curso_id'] ?>">
                            <button type="submit">📄 Baixar Certificado</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>📭 Nenhum certificado disponível ainda. Complete cursos para liberar certificados!</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
