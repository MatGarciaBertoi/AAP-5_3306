<?php
session_start();
include_once('../../funcoes/conexao.php');
include_once('funcoes/verificar_inscricao.php');
include_once('funcoes/funcoes.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;
$aluno_id = $_SESSION['id'];

// Verifica inscrição
if (!alunoTemAcesso($conexao, $aluno_id, $curso_id)) {
    echo "Você não tem acesso a este curso.";
    exit();
}

// Busca aulas
$stmt = $conexao->prepare(
    "SELECT a.id, a.titulo, a.conteudo, a.video_url, pa.concluida 
     FROM aulas a 
     LEFT JOIN progresso_aula pa ON pa.aula_id = a.id AND pa.aluno_id = ?
     WHERE a.curso_id = ? 
     ORDER BY a.id ASC"
);
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$aulas = $stmt->get_result();

// Busca avaliações
$stmt = $conexao->prepare(
    "SELECT id, titulo, descricao, tipo, data_criacao 
     FROM avaliacoes 
     WHERE curso_id = ? 
     ORDER BY data_criacao DESC"
);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$avaliacoes = $stmt->get_result();
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

        <div class="tabs">
            <button class="tab-button active" onclick="mostrarAba('aulas')">🎥 Aulas em Vídeo</button>
            <button class="tab-button" onclick="mostrarAba('avaliacoes')">📝 Avaliações</button>
        </div>

        <div id="aulas" class="tab-content active">
            <?php while ($aula = $aulas->fetch_assoc()): ?>
                <div class="aula-card">
                    <h2><?= htmlspecialchars($aula['titulo']); ?></h2>
                    <?php if (!empty($aula['video_url'])): ?>
                        <div class="video-container">
                            <?php $videoEmbed = transformarParaEmbed($aula['video_url']); ?>
                            <iframe width="100%" height="315" src="<?= htmlspecialchars($videoEmbed); ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                    <p><?= nl2br(htmlspecialchars($aula['conteudo'])); ?></p>

                    <?php if ($aula['concluida']): ?>
                        <button class="done" disabled>✅ Aula Concluída</button>
                    <?php else: ?>
                        <form action="funcoes/marcar_concluida.php?curso_id=<?= $curso_id ?>" method="POST">
                            <input type="hidden" name="aula_id" value="<?= $aula['id']; ?>">
                            <button type="submit">Marcar como concluída</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <div id="avaliacoes" class="tab-content">
            <?php if ($avaliacoes->num_rows > 0): ?>
                <?php while ($avaliacao = $avaliacoes->fetch_assoc()): ?>
                    <div class="avaliacao-card">
                        <h2><?= htmlspecialchars($avaliacao['titulo']); ?> (<?= $avaliacao['tipo']; ?>)</h2>
                        <p><?= nl2br(htmlspecialchars($avaliacao['descricao'])); ?></p>
                        <p><strong>Criada em:</strong> <?= date('d/m/Y', strtotime($avaliacao['data_criacao'])); ?></p>
                        <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>" class="botao">Fazer Avaliação</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>📭 Nenhuma avaliação disponível no momento.</p>
            <?php endif; ?>
        </div>

        <a href="abacursos.php?curso_id=<?= $curso_id ?>" class="voltar">🔙 Voltar</a>
    </div>

    <script>
        function mostrarAba(abaId) {
            const abas = document.querySelectorAll('.tab-content');
            const botoes = document.querySelectorAll('.tab-button');

            abas.forEach(aba => aba.classList.remove('active'));
            botoes.forEach(botao => botao.classList.remove('active'));

            document.getElementById(abaId).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>

</html>