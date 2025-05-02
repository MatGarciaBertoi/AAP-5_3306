<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id'], $_SESSION['tipo'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: ../login.php');
    exit;
}

// Processa o termo de busca
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

// Consulta com busca opcional
$sql = "
    SELECT a.id, a.titulo, a.conteudo, a.video_url, a.criado_em, c.nome AS nome_curso 
    FROM aulas a
    JOIN cursos c ON a.curso_id = c.id
    WHERE c.criado_por_id = ? AND c.tipo_criador = ?
";

if ($busca !== '') {
    $sql .= " AND (a.titulo LIKE ? OR c.nome LIKE ?)";
}

$sql .= " ORDER BY a.criado_em DESC";

$stmt = $conexao->prepare($sql);

if ($busca !== '') {
    $likeBusca = '%' . $busca . '%';
    $stmt->bind_param("isss", $_SESSION['id'], $_SESSION['tipo'], $likeBusca, $likeBusca);
} else {
    $stmt->bind_param("is", $_SESSION['id'], $_SESSION['tipo']);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Minhas Aulas - CW Cursos</title>
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/aulas.css">
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <div class="container">
        <h1>Minhas Aulas</h1>

        <form method="GET" class="form-pesquisa" style="margin-bottom: 20px;">
            <div class="pesquisa-aulas">
                <input type="text" id="buscaAulas" name="busca" placeholder="Buscar por título ou curso..." value="<?= htmlspecialchars($busca) ?>">
            </div>
        </form>

        <a href="add_aula.php" class="btn-voltar">➕ Adicionar nova aula</a>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <p class="mensagem <?= $_SESSION['mensagem_tipo'] ?>">
                <?= $_SESSION['mensagem'] ?>
            </p>
            <?php unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); ?>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <ul class="aulas-lista">
                <?php while ($aula = $result->fetch_assoc()): ?>
                    <li class="aula-item">
                        <h2><?= htmlspecialchars($aula['titulo']) ?> <small>(<?= htmlspecialchars($aula['nome_curso']) ?>)</small></h2>
                        <p><?= nl2br(htmlspecialchars($aula['conteudo'])) ?></p>
                        <p><strong>Vídeo:</strong> <a href="<?= htmlspecialchars($aula['video_url']) ?>" target="_blank">Assistir</a></p>
                        <p><em>Criado em: <?= date('d/m/Y H:i', strtotime($aula['criado_em'])) ?></em></p>

                        <div class="acoes-aula">
                            <a href="editar_aula.php?id=<?= $aula['id'] ?>" class="btn-editar">✏️ Editar</a>
                            <a href="funcoes/excluir_aula.php?= $aula['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta aula?');">🗑️ Excluir</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma aula encontrada.</p>
        <?php endif; ?>
    </div>

    <?php include 'partials/footer.php'; ?>
    <script>
        document.getElementById('buscaAulas').addEventListener('input', function() {
            const termo = this.value.toLowerCase();

            document.querySelectorAll('.aula-item').forEach(function(item) {
                const titulo = item.querySelector('h2').innerText.toLowerCase();
                const curso = item.querySelector('h2 small')?.innerText.toLowerCase() || '';
                item.style.display = (titulo.includes(termo) || curso.includes(termo)) ? 'block' : 'none';
            });
        });
    </script>

</body>

</html>