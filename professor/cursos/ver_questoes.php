<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    die("Acesso negado. Faça login.");
}

$avaliacao_id = isset($_GET['avaliacao_id']) ? (int) $_GET['avaliacao_id'] : 0;

// Buscar dados da avaliação
$sqlAval = "SELECT * FROM avaliacoes WHERE id = ?";
$stmtAval = $conexao->prepare($sqlAval);
$stmtAval->bind_param("i", $avaliacao_id);
$stmtAval->execute();
$resultAval = $stmtAval->get_result();
$avaliacao = $resultAval->fetch_assoc();

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}

// Buscar questões
$sqlQuestoes = "SELECT * FROM questoes WHERE avaliacao_id = ?";
$stmtQuestoes = $conexao->prepare($sqlQuestoes);
$stmtQuestoes->bind_param("i", $avaliacao_id);
$stmtQuestoes->execute();
$questoes = $stmtQuestoes->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Questões de <?php echo htmlspecialchars($avaliacao['titulo']); ?></title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="css/ver_conteudo.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Questões de "<?php echo htmlspecialchars($avaliacao['titulo'] ?? ''); ?> "</h1>

        <a href="adicionar_questao.php?avaliacao_id=<?php echo $avaliacao_id; ?>" style="margin-bottom: 15px; display: inline-block; background-color: #2ecc71; color: white; padding: 10px; border-radius: 4px; text-decoration: none;">+ Adicionar Nova Questão</a>

        <?php if ($questoes->num_rows > 0): ?>
            <?php while ($q = $questoes->fetch_assoc()): ?>
                <div class="item-card">
                    <strong>Enunciado:</strong>
                    <p><?php echo nl2br(htmlspecialchars($q['enunciado'] ?? '')); ?></p>

                    <p><strong>Tipo:</strong> <?php echo $q['tipo'] == 'multipla_escolha' ? 'Múltipla escolha' : 'Dissertativa'; ?></p>

                    <?php if ($q['tipo'] === 'multipla_escolha' && $q['alternativas']): ?>
                        <p><strong>Alternativas:</strong></p>
                        <ul>
                            <?php
                            $alternativas = json_decode($q['alternativas'], true);
                            foreach ($alternativas as $letra => $texto): ?>
                                <li><?php echo $letra . ') ' . htmlspecialchars($texto); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p><strong>Resposta correta:</strong>
                            <?php
                            $alternativa_correta_letra = $q['resposta_correta']; // ex: 'b'
                            if (isset($alternativas[$alternativa_correta_letra])) {
                                echo $alternativa_correta_letra . ') ' . htmlspecialchars($alternativas[$alternativa_correta_letra]);
                            } else {
                                echo 'Não definida';
                            }
                            ?>
                        </p>
                    <?php elseif ($q['tipo'] === 'dissertativa'): ?>
                        <p><strong>Resposta esperada:</strong> <?php echo nl2br(htmlspecialchars($q['resposta_correta'] ?? '')); ?></p>
                    <?php endif; ?>

                    <div style="margin-top: 10px;">
                        <a href="editar_questao.php?id=<?php echo $q['id']; ?>" style="color: blue; margin-right: 15px;">Editar</a>
                        <a href="funcoes/remover_questao.php?id=<?php echo $q['id']; ?>" style="color: red;" onclick="return confirm('Tem certeza que deseja excluir esta questão?');">Remover</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhuma questão cadastrada ainda para esta avaliação.</p>
        <?php endif; ?>

        <br>
        <a href="ver_conteudo_curso.php?id=<?php echo $avaliacao['curso_id']; ?>" style="text-decoration: none; color: gray;">← Voltar para o curso</a>
    </div>
</body>

</html>