<?php
include_once('../funcoes/sessoes/check_aluno.php');
include_once('../funcoes/conexao.php');

$alunoId = $_SESSION['id'];

// Buscar plano atual do aluno
$sql = "SELECT * FROM assinaturas WHERE aluno_id = ? ORDER BY data_assinatura DESC LIMIT 1";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $alunoId);
$stmt->execute();
$result = $stmt->get_result();
$planoAtual = $result->fetch_assoc(); // pode ser false se não tiver plano

// Definir os planos disponíveis
$planos = [
    'Essencial' => [
        'desc' => 'Ideal para quem quer acesso completo aos nossos cursos.',
        'beneficios' => [
            'Acesso ilimitado a todos os cursos',
            'Material de apoio',
            'Certificados digitais'
        ]
    ],
    'Profissional' => [
        'desc' => 'Para quem busca suporte e aprendizado contínuo.',
        'beneficios' => [
            'Todos os benefícios do Essencial +',
            'Webinars exclusivos',
            'Suporte prioritário'
        ]
    ],
    'Empreendedor' => [
        'desc' => 'Para quem quer escalar seus resultados com acompanhamento especial.',
        'beneficios' => [
            'Todos os benefícios do Profissional +',
            'Mentorias ao vivo',
            'Consultoria personalizada',
            'Acesso antecipado a novos cursos'
        ]
    ]
];
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
                <p><strong>Plano:</strong> <?= htmlspecialchars($planoAtual['plano']) ?></p>
                <p><strong>Data da Assinatura:</strong> <?= date('d/m/Y', strtotime($planoAtual['data_assinatura'])) ?></p>
                <p><strong>Data de Expiração:</strong> <?= $planoAtual['data_expiracao'] ? date('d/m/Y', strtotime($planoAtual['data_expiracao'])) : 'Indefinido' ?></p>
            <?php else: ?>
                <p>Você ainda não assinou nenhum plano.</p>
            <?php endif; ?>

        </div>
        <section class="planos-section">
            <h2>Alterar Plano</h2>
            <div class="planos-container">

                <?php foreach ($planos as $nome => $dados): ?>
                    <div class="plano-card<?= ($planoAtual && $planoAtual['plano'] === $nome) ? ' destaque' : '' ?>">
                        <h3><?= $nome ?></h3>
                        <p><?= $dados['desc'] ?></p>
                        <ul>
                            <?php foreach ($dados['beneficios'] as $beneficio): ?>
                                <li><?= $beneficio ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ($planoAtual && $planoAtual['plano'] === $nome): ?>
                            <span class="btn-assinar" style="background: gray;">Plano Atual</span>
                        <?php else: ?>
                            <a href="assinar_plano.php?plano=<?= urlencode($nome) ?>" class="btn-assinar">
                                <?= $planoAtual ? 'Alterar para este plano' : 'Assinar' ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </section>
        <!-- Botões -->
        <div class="action-buttons">
            <a href="areadoaluno.php">Ir para Área do Aluno</a>
            <a href="../TelaInicial/index.php">Ir para Menu Inicial</a>
        </div>
    </div>

    <!-- Chatra {literal} -->
    <script>
        (function(d, w, c) {
            w.ChatraID = 'igHEh7N4PEvoDEkR7';
            var s = d.createElement('script');
            w[c] = w[c] || function() {
                (w[c].q = w[c].q || []).push(arguments);
            };
            s.async = true;
            s.src = 'https://call.chatra.io/chatra.js';
            if (d.head) d.head.appendChild(s);
        })(document, window, 'Chatra');
        window.ChatraSetup = {
            colors: {
                buttonText: '#202124',
                /* chat button text color */
                buttonBg: '#F1F3F4' /* chat button background color */
            }
        };
    </script>
    <!-- /Chatra {/literal} -->
</body>

</html>