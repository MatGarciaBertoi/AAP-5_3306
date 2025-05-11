<?php
session_start();
include_once('../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;
$aluno_id = $_SESSION['id'];

// Verifica se o aluno está inscrito
$verifica_sql = "SELECT 1 FROM inscricoes WHERE aluno_id = ? AND curso_id = ?";
$stmt = $conexao->prepare($verifica_sql);
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Você não tem acesso a este curso.";
    exit();
}

// Busca as aulas
$sql = "SELECT a.id, a.titulo, a.conteudo, a.video_url, 
               pa.concluida 
        FROM aulas a 
        LEFT JOIN progresso_aula pa 
        ON pa.aula_id = a.id AND pa.aluno_id = ?
        WHERE a.curso_id = ? 
        ORDER BY a.id ASC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$aulas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Conteúdo do Curso</title>
    <link rel="stylesheet" href="css/ver_conteudo.css">
</head>

<body>
    <div class="container">
        <h1>Conteúdo do Curso</h1>
        <div class="aulas-lista">
            <?php while ($aula = $aulas->fetch_assoc()): ?>
                <div class="aula-card">
                    <h2><?= htmlspecialchars($aula['titulo']); ?></h2>

                    <?php if (!empty($aula['video_url'])): ?>
                        <div class="video-container">
                            <?php
                            // Converte o link padrão do YouTube para o link de incorporação
                            function transformarParaEmbed($url)
                            {
                                if (strpos($url, 'watch?v=') !== false) {
                                    return preg_replace('/watch\?v=([a-zA-Z0-9_-]+)/', 'embed/$1', $url);
                                }
                                return $url;
                            }

                            $videoEmbed = transformarParaEmbed($aula['video_url']);
                            ?>
                            <iframe width="100%" height="315" src="<?= htmlspecialchars($videoEmbed); ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>

                    <p><?= nl2br(htmlspecialchars($aula['conteudo'])); ?></p>

                    <?php if ($aula['concluida']): ?>
                        <button class="done" disabled>✅ Aula Concluída</button>
                    <?php else: ?>
                        <form action="marcar_concluida.php" method="POST">
                            <input type="hidden" name="aula_id" value="<?= $aula['id']; ?>">
                            <button type="submit">Marcar como concluída</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="abacursos.php?curso_id=<?= $curso_id ?>" class="voltar">🔙 Voltar</a>
    </div>
</body>

</html>