<?php
session_start();
include_once('../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

$aluno_id = $_SESSION['id'];
$avaliacao_id = isset($_GET['avaliacao_id']) ? intval($_GET['avaliacao_id']) : 0;
$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;

// Buscar questões da avaliação
$questoes_stmt = $conexao->prepare("SELECT * FROM questoes WHERE avaliacao_id = ?");
$questoes_stmt->bind_param("i", $avaliacao_id);
$questoes_stmt->execute();
$questoes_result = $questoes_stmt->get_result();

$questoes = [];
while ($q = $questoes_result->fetch_assoc()) {
    $questoes[] = $q;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostas = $_POST['respostas'] ?? [];
    $nota_total = 0;
    $total_multipla = 0;

        $id_questao = $q['id'];
        $tipo = $q['tipo'];
        $resposta_correta = trim($q['resposta_correta']);
        $resposta_aluno = trim($respostas[$id_questao] ?? '');

        // Corrigir apenas questões de múltipla escolha
        if ($tipo === 'multipla_escolha' && $resposta_correta !== '') {
            $total_multipla++;

            // Comparação segura ignorando maiúsculas/minúsculas e espaços
            if (mb_strtolower($resposta_aluno) === mb_strtolower($resposta_correta)) {
                $nota_total++;
            }
        }
    }

    // Calcular nota apenas sobre questões objetivas
    $nota_final = $total_multipla > 0 ? ($nota_total / $total_multipla) * 10 : 0;
    $json_respostas = json_encode($respostas, JSON_UNESCAPED_UNICODE);

    // Buscar a próxima tentativa
    $stmt = $conexao->prepare("SELECT MAX(tentativa) AS max_tentativa FROM respostas_alunos WHERE avaliacao_id = ? AND aluno_id = ?");
    $stmt->bind_param("ii", $avaliacao_id, $aluno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $tentativa = isset($row['max_tentativa']) ? $row['max_tentativa'] + 1 : 1;

    // Inserir nova tentativa
    $insere = $conexao->prepare("INSERT INTO respostas_alunos (avaliacao_id, aluno_id, resposta, nota, tentativa, data_envio) VALUES (?, ?, ?, ?, ?, NOW())");
    $insere->bind_param("iisdi", $avaliacao_id, $aluno_id, $json_respostas, $nota_final, $tentativa);
    $insere->execute();

    echo "<div style='...'>
    ✅ Avaliação enviada com sucesso!<br>
    Sua nota: <strong>" . number_format($nota_final, 2, ',', '.') . "</strong><br>
    Tentativa nº: <strong>{$tentativa}</strong><br>
    <a href='ver_conteudo.php?curso_id=$curso_id'>🔙 Voltar ao conteúdo</a>
</div>";

    flush(); // Força o envio do conteúdo ao navegador
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Fazer Avaliação</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f9f9f9;
        }

        .questao {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        label {
            display: block;
            margin-top: 8px;
        }

        button {
            padding: 10px 20px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <h2>📝 Responder Avaliação</h2>
    <form method="POST">
        <?php foreach ($questoes as $q): ?>
            <div class="questao">
                <p><strong><?= htmlspecialchars($q['enunciado']) ?></strong></p>

                <?php if ($q['tipo'] === 'multipla_escolha'): ?>
                    <?php
                    $alternativas = json_decode($q['alternativas'], true);
                    $letras = range('A', 'Z');
                    $index = 0;
                    foreach ($alternativas as $chave => $texto):
                        // Se for array simples (0,1,2...), transforma em A, B, C...
                        $letra = is_string($chave) ? $chave : $letras[$index];
                        $index++;
                    ?>
                        <label>
                            <input type="radio" name="respostas[<?= $q['id'] ?>]" value="<?= htmlspecialchars($letra) ?>" required>
                            <?= htmlspecialchars("{$letra}) {$texto}") ?>
                        </label>
                    <?php endforeach; ?>
                <?php elseif ($q['tipo'] === 'dissertativa'): ?>
                    <textarea name="respostas[<?= $q['id'] ?>]" rows="4" cols="50" required></textarea>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit">Enviar Avaliação</button>
    </form>
</body>

</html>