<?php
include_once('../../funcoes/sessoes/check_aluno.php');
include_once('../../funcoes/conexao.php');

$aluno_id = $_SESSION['id'];
$avaliacao_id = isset($_GET['avaliacao_id']) ? intval($_GET['avaliacao_id']) : 0;
$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;

// Buscar o tipo da avaliação
$tipo_avaliacao = '';
$tipo_stmt = $conexao->prepare("SELECT tipo FROM avaliacoes WHERE id = ?");
$tipo_stmt->bind_param("i", $avaliacao_id);
$tipo_stmt->execute();
$tipo_result = $tipo_stmt->get_result();

if ($tipo_row = $tipo_result->fetch_assoc()) {
    $tipo_avaliacao = $tipo_row['tipo']; // Ex: "Prova", "Questionário", etc.
}

// Buscar questões da avaliação
$questoes_stmt = $conexao->prepare("SELECT * FROM questoes WHERE avaliacao_id = ?");
$questoes_stmt->bind_param("i", $avaliacao_id);
$questoes_stmt->execute();
$questoes_result = $questoes_stmt->get_result();

$questoes = [];
while ($q = $questoes_result->fetch_assoc()) {
    $questoes[] = $q;
}

// Buscar a última tentativa e as respostas anteriores, se existirem
$stmt = $conexao->prepare("SELECT * FROM respostas_alunos WHERE avaliacao_id = ? AND aluno_id = ? ORDER BY tentativa DESC LIMIT 1");
$stmt->bind_param("ii", $avaliacao_id, $aluno_id);
$stmt->execute();
$result = $stmt->get_result();
$resposta_anterior = $result->fetch_assoc();

$respostas_anteriores = [];
$tentativa_anterior = 0;

if ($resposta_anterior) {
    $respostas_anteriores = json_decode($resposta_anterior['resposta'], true);
    $tentativa_anterior = $resposta_anterior['tentativa'];
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostas = $_POST['respostas'] ?? [];
    $nota_total = 0;
    $total_multipla = 0;

    foreach ($questoes as $q) {
        $id_questao = $q['id'];
        $tipo = $q['tipo'];
        $resposta_correta = trim($q['resposta_correta']);
        $resposta_aluno = trim($respostas[$id_questao] ?? '');

        if ($tipo === 'multipla_escolha' && $resposta_correta !== '') {
            $total_multipla++;

            if (mb_strtolower($resposta_aluno) === mb_strtolower($resposta_correta)) {
                $nota_total++;
            }
        }
    }

    $nota_final = $total_multipla > 0 ? ($nota_total / $total_multipla) * 10 : 0;
    $json_respostas = json_encode($respostas, JSON_UNESCAPED_UNICODE);
    $nova_tentativa = $tentativa_anterior + 1;

    $insere = $conexao->prepare("INSERT INTO respostas_alunos (avaliacao_id, aluno_id, resposta, nota, tentativa, data_envio) VALUES (?, ?, ?, ?, ?, NOW())");
    $insere->bind_param("iisdi", $avaliacao_id, $aluno_id, $json_respostas, $nota_final, $nova_tentativa);
    $insere->execute();

    echo "<div style='background:#e0ffe0;padding:15px;border-radius:6px;margin:20px 0;'>
✅ Avaliação enviada com sucesso!<br>";

    if (mb_strtolower($tipo_avaliacao) === 'prova') {
        echo "Sua nota: <strong>" . number_format($nota_final, 2, ',', '.') . "</strong><br>";
    }

    echo "Tentativa nº: <strong>{$nova_tentativa}</strong><br>";

    // Mostrar gabarito completo apenas se for Atividade
    if (mb_strtolower($tipo_avaliacao) === 'atividade') {
        echo "<h4>📘 Respostas corretas esperadas:</h4><ul>";

        foreach ($questoes as $q) {
            echo "<li><strong>" . htmlspecialchars($q['enunciado']) . "</strong><br>";

            if ($q['tipo'] === 'multipla_escolha' && !empty($q['resposta_correta'])) {
                $alternativas = json_decode($q['alternativas'], true);
                $resposta_correta = strtoupper(trim($q['resposta_correta']));
                $texto_correto = $alternativas[$resposta_correta] ?? 'Alternativa não encontrada';
                echo "Resposta correta: <strong>{$resposta_correta}) " . htmlspecialchars($texto_correto) . "</strong>";
            } elseif ($q['tipo'] === 'dissertativa' && !empty($q['resposta_correta'])) {
                echo "Resposta esperada: <em>" . nl2br(htmlspecialchars($q['resposta_correta'])) . "</em>";
            } else {
                echo "<em>Nenhuma resposta correta cadastrada.</em>";
            }

            echo "</li><br>";
        }

        echo "</ul>";
    }

    echo "<a href='ver_conteudo.php?curso_id=$curso_id'>🔙 Voltar ao conteúdo</a></div>";



    flush();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Fazer Avaliação</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="css/avaliacao.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">
        <h2>📝 Responder Avaliação</h2>
        <form method="POST">
            <?php foreach ($questoes as $q): ?>
                <div class="questao">
                    <p><strong><?= htmlspecialchars($q['enunciado']) ?></strong></p>

                    <?php
                    $resposta_anterior = $respostas_anteriores[$q['id']] ?? '';
                    ?>

                    <?php if ($q['tipo'] === 'multipla_escolha'): ?>
                        <?php
                        $alternativas = json_decode($q['alternativas'], true);
                        $letras = range('A', 'Z');
                        $index = 0;
                        foreach ($alternativas as $chave => $texto):
                            $letra = is_string($chave) ? $chave : $letras[$index];
                            $index++;
                            $checked = ($resposta_anterior === $letra) ? 'checked' : '';
                        ?>
                            <label>
                                <input type="radio" name="respostas[<?= $q['id'] ?>]" value="<?= htmlspecialchars($letra) ?>" <?= $checked ?> required>
                                <?= htmlspecialchars("{$letra}) {$texto}") ?>
                            </label>
                        <?php endforeach; ?>
                    <?php elseif ($q['tipo'] === 'dissertativa'): ?>
                        <textarea name="respostas[<?= $q['id'] ?>]" rows="4" cols="50" required><?= htmlspecialchars($resposta_anterior) ?></textarea>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit">Enviar Avaliação</button>
            <a href="ver_conteudo.php?curso_id=<?= $curso_id ?>" class="cancelar">Cancelar</a>
        </form>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>