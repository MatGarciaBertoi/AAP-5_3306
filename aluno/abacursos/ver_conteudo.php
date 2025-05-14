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

// Verifica se todas as aulas estão concluídas
$stmt = $conexao->prepare("SELECT COUNT(*) AS total_aulas FROM aulas WHERE curso_id = ?");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$total_aulas = $result->fetch_assoc()['total_aulas'];

$stmt = $conexao->prepare("SELECT COUNT(*) AS aulas_concluidas FROM progresso_aula pa 
                           JOIN aulas a ON a.id = pa.aula_id 
                           WHERE pa.aluno_id = ? AND a.curso_id = ? AND pa.concluida = 1");
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$aulas_concluidas = $result->fetch_assoc()['aulas_concluidas'];

// Verifica se todas as atividades foram feitas
$stmt = $conexao->prepare("SELECT COUNT(*) AS total_atividades 
                           FROM avaliacoes 
                           WHERE curso_id = ? AND tipo = 'Atividade'");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$total_atividades = $result->fetch_assoc()['total_atividades'];

$stmt = $conexao->prepare("SELECT COUNT(*) AS atividades_feitas 
                           FROM respostas_alunos ra 
                           JOIN avaliacoes a ON a.id = ra.avaliacao_id 
                           WHERE ra.aluno_id = ? AND a.curso_id = ? AND a.tipo = 'Atividade'");
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$atividades_feitas = $result->fetch_assoc()['atividades_feitas'];

// Verifica se a prova foi feita com nota >= 7
$stmt = $conexao->prepare("SELECT nota 
                           FROM respostas_alunos ra 
                           JOIN avaliacoes a ON a.id = ra.avaliacao_id 
                           WHERE ra.aluno_id = ? AND a.curso_id = ? AND a.tipo = 'Prova' 
                           ORDER BY ra.data_envio DESC 
                           LIMIT 1");
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$nota_prova = 0;
if ($row = $result->fetch_assoc()) {
    $nota_prova = floatval($row['nota']);
}

// Verifica se pode liberar certificado com 70% ou mais na prova
$certificado_liberado = (
    $aulas_concluidas == $total_aulas &&
    $atividades_feitas == $total_atividades &&
    $nota_prova >= 7.0 // 70% de 10
);

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

// Busca notas das avaliações já feitas
$notas_avaliacoes = [];
$stmt = $conexao->prepare(
    "SELECT avaliacao_id, nota 
     FROM respostas_alunos 
     WHERE aluno_id = ?"
);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result_notas = $stmt->get_result();
while ($row = $result_notas->fetch_assoc()) {
    $notas_avaliacoes[$row['avaliacao_id']] = $row['nota'];
}
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

                        <?php if (isset($notas_avaliacoes[$avaliacao['id']])): ?>
                            <p><strong>Nota:</strong> <?= $notas_avaliacoes[$avaliacao['id']]; ?> / 10.00</p>
                            <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>&refazer=1" class="botao">🔁 Refazer Avaliação</a>
                        <?php else: ?>
                            <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>" class="botao">Fazer Avaliação</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>📭 Nenhuma avaliação disponível no momento.</p>
            <?php endif; ?>
        </div>

        <?php if ($certificado_liberado): ?>
            <div class="certificado">
                <form action="gerar_certificado.php" method="POST" target="_blank">
                    <input type="hidden" name="curso_id" value="<?= $curso_id ?>">
                    <button type="submit" class="botao">🎓 Baixar Certificado</button>
                </form>
            </div>
        <?php else: ?>
            <div class="certificado">
                <h2>Status do Certificado</h2>
                <?php if ($certificado_liberado): ?>
                    <p>🎉 Parabéns! Você concluiu todos os requisitos. <a href="gerar_certificado.php?curso_id=<?= $curso_id ?>">Clique aqui para gerar seu certificado.</a></p>
                <?php else: ?>
                    <p>🔒 Complete todas as aulas, atividades e tenha pelo menos 70% de aproveitamento na prova para liberar o certificado.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

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