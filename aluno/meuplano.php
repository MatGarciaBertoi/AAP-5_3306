<?php
include_once('../funcoes/sessoes/check_aluno.php');
include_once('../funcoes/conexao.php');

$alunoId = $_SESSION['id'];

// Buscar plano atual com nome do plano
$sql = "SELECT a.*, p.nome AS plano_nome FROM assinaturas a
        JOIN planos p ON a.plano_id = p.id
        WHERE a.aluno_id = ?
        ORDER BY a.data_assinatura DESC
        LIMIT 1";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $alunoId);
$stmt->execute();
$result = $stmt->get_result();
$planoAtual = $result->fetch_assoc(); // pode ser false

// Buscar todos os planos ativos
$sql_planos = "SELECT * FROM planos WHERE ativo = 1 ORDER BY preco ASC";
$planos_result = $conexao->query($sql_planos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - Meu Plano</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/meuplano.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include '../funcoes/usuario/acessibilidade.php'; ?>

    <div class="content-main">
        <div class="plano-container">
            <h2>Meu Plano Atual</h2>
            <?php if ($planoAtual): ?>
                <p><strong>Plano:</strong> <?= htmlspecialchars($planoAtual['plano_nome']) ?></p>
                <p><strong>Data da Assinatura:</strong> <?= date('d/m/Y', strtotime($planoAtual['data_assinatura'])) ?></p>
                <p><strong>Data de Expiração:</strong> <?= $planoAtual['data_expiracao'] ? date('d/m/Y', strtotime($planoAtual['data_expiracao'])) : 'Indefinido' ?></p>
            <?php else: ?>
                <p>Você ainda não assinou nenhum plano.</p>
            <?php endif; ?>
        </div>

        <section class="planos-section">
            <h2>Alterar Plano</h2>
            <div class="planos-container">
                <?php while ($plano = $planos_result->fetch_assoc()): ?>
                    <?php
                    $beneficios = !empty($plano['beneficios']) ? explode("\n", trim($plano['beneficios'])) : [];
                    $planoAtivo = $planoAtual && $planoAtual['plano_id'] == $plano['id'];
                    ?>
                    <div class="plano-card<?= $planoAtivo ? ' destaque' : '' ?>">
                        <h3><?= htmlspecialchars($plano['nome']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($plano['descricao'])) ?></p>
                        <p><strong>R$ <?= number_format($plano['preco'], 2, ',', '.') ?> / mês</strong></p>
                        <?php if ($beneficios): ?>
                            <ul>
                                <?php foreach ($beneficios as $beneficio): ?>
                                    <li><?= htmlspecialchars($beneficio) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if ($planoAtivo): ?>
                            <span class="btn-assinar" style="background: gray;">Plano Atual</span>
                        <?php else: ?>
                            <a href="assinar_plano.php?plano=<?= urlencode($plano['nome']) ?>" class="btn-assinar">
                                <?= $planoAtual ? 'Alterar para este plano' : 'Assinar' ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>

        <div class="action-buttons">
            <a href="areadoaluno.php">Ir para Área do Aluno</a>
            <a href="../TelaInicial/index.php">Ir para Menu Inicial</a>
        </div>
    </div>

    <!-- Chatra {literal} -->
    <script src="../funcoes/chatbot/suporte/chatra.js"> </script>
</body>

</html>