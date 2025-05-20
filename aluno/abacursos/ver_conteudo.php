<?php
include_once('../../funcoes/sessoes/check_aluno.php');
include_once('../../funcoes/conexao.php');
include_once('funcoes/verificar_inscricao.php');
include_once('funcoes/funcoes.php');

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

// Verifica se todas as provas foram feitas e com nota >= 7
$stmt = $conexao->prepare(
    "SELECT a.id 
     FROM avaliacoes a
     WHERE a.curso_id = ? AND a.tipo = 'Prova'"
);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result_provas = $stmt->get_result();

$provas_feitas_com_nota = 0;
$total_provas = $result_provas->num_rows;

while ($prova = $result_provas->fetch_assoc()) {
    $avaliacao_id = $prova['id'];

    // Busca a nota do aluno para cada prova
    $stmt2 = $conexao->prepare(
        "SELECT ra.nota
     FROM respostas_alunos ra
     INNER JOIN (
         SELECT MAX(data_envio) AS ultima_tentativa
         FROM respostas_alunos
         WHERE aluno_id = ? AND avaliacao_id = ?
     ) ult ON ra.data_envio = ult.ultima_tentativa
     WHERE ra.aluno_id = ? AND ra.avaliacao_id = ?"
    );
    $stmt2->bind_param("iiii", $aluno_id, $avaliacao_id, $aluno_id, $avaliacao_id);
    $stmt2->execute();
    $res_nota = $stmt2->get_result();

    if ($res_nota->num_rows > 0) {
        $nota = floatval($res_nota->fetch_assoc()['nota']);
        if ($nota >= 7.0) {
            $provas_feitas_com_nota++;
        }
    }
    $stmt2->close();
}

// Verifica se pode liberar certificado
$certificado_liberado = (
    $aulas_concluidas == $total_aulas &&
    $provas_feitas_com_nota == $total_provas
);

if ($certificado_liberado) {
    // Verifica se já está registrado
    $stmt = $conexao->prepare("SELECT id FROM cursos_concluidos WHERE aluno_id = ? AND curso_id = ?");
    $stmt->bind_param("ii", $aluno_id, $curso_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se ainda não existe, insere
    if ($result->num_rows === 0) {
        $stmt = $conexao->prepare("INSERT INTO cursos_concluidos (aluno_id, curso_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $aluno_id, $curso_id);
        $stmt->execute();
    }
}

// Busca avaliações
$stmt = $conexao->prepare(
    "SELECT id, titulo, descricao, tipo, data_criacao 
     FROM avaliacoes 
     WHERE curso_id = ? 
     ORDER BY 
        CASE 
            WHEN tipo = 'Atividade' THEN 1 
            WHEN tipo = 'Prova' THEN 2 
            ELSE 3 
        END,
        data_criacao DESC"
);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$avaliacoes = $stmt->get_result();

// Busca notas das avaliações já feitas
$notas_avaliacoes = [];
$stmt = $conexao->prepare(
    "SELECT ra.avaliacao_id, ra.nota
     FROM respostas_alunos ra
     INNER JOIN (
         SELECT avaliacao_id, MAX(data_envio) AS ultima_tentativa
         FROM respostas_alunos
         WHERE aluno_id = ?
         GROUP BY avaliacao_id
     ) ultimas ON ra.avaliacao_id = ultimas.avaliacao_id AND ra.data_envio = ultimas.ultima_tentativa
     WHERE ra.aluno_id = ?"
);
$stmt->bind_param("ii", $aluno_id, $aluno_id);
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
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="css/ver_conteudo.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
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

                        <?php
                        // Verifica se o aluno já respondeu esta avaliação
                        $fez_avaliacao = isset($notas_avaliacoes[$avaliacao['id']]);
                        ?>

                        <?php if ($avaliacao['tipo'] === 'Prova'): ?>
                            <?php if ($fez_avaliacao): ?>
                                <p><strong>Nota:</strong> <?= $notas_avaliacoes[$avaliacao['id']]; ?> / 10.00</p>
                                <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>&refazer=1" class="botao">🔁 Refazer Avaliação</a>
                            <?php else: ?>
                                <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>" class="botao">Fazer Avaliação</a>
                            <?php endif; ?>

                        <?php elseif ($avaliacao['tipo'] === 'Atividade'): ?>
                            <?php if ($fez_avaliacao): ?>
                                <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>&refazer=1" class="botao">🔁 Refazer Atividade</a>
                            <?php else: ?>
                                <a href="fazer_avaliacao.php?avaliacao_id=<?= $avaliacao['id']; ?>&curso_id=<?= $curso_id ?>" class="botao">Fazer Atividade</a>
                            <?php endif; ?>

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
            <?php
            // Verifica se o aluno já enviou feedback
            $stmt = $conexao->prepare("SELECT id FROM feedbacks WHERE aluno_id = ? AND curso_id = ?");
            $stmt->bind_param("ii", $aluno_id, $curso_id);
            $stmt->execute();
            $res_feedback = $stmt->get_result();
            $ja_enviou_feedback = $res_feedback->num_rows > 0;
            ?>

            <div class="feedback">
                <h2>🗣️ Queremos saber sua opinião!</h2>

                <?php if (isset($_SESSION['mensagem_feedback'])): ?>
                    <p><?= $_SESSION['mensagem_feedback'];
                        unset($_SESSION['mensagem_feedback']); ?></p>
                <?php endif; ?>

                <?php if (!$ja_enviou_feedback): ?>
                    <form action="funcoes/enviar_feedback.php" method="POST">
                        <input type="hidden" name="curso_id" value="<?= $curso_id ?>">
                        <textarea name="comentario" rows="5" style="width: 100%;" placeholder="Deixe seu feedback sobre o curso..."></textarea><br>
                        <button type="submit" class="botao">📨 Enviar Feedback</button>
                    </form>
                <?php else: ?>
                    <p>✅ Você já enviou seu feedback. Obrigado por contribuir!</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

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

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->

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