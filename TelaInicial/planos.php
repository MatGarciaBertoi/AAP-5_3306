<?php 
session_start();

include_once '../funcoes/conexao.php';

// Consulta os planos ativos
$sql = "SELECT * FROM planos WHERE ativo = 1";
$result = mysqli_query($conexao, $sql);

// Verifica se houve erro na consulta
if (!$result) {
    die("Erro ao buscar planos: " . mysqli_error($conexao));
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Marketing Digital</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/planos.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <main>
        <div class="container">
            <div class="content-main">
                <section class="planos-section">
                    <h2>Escolha seu Plano</h2>
                    <div class="planos-container">

                        <?php while ($plano = mysqli_fetch_assoc($result)): ?>
                            <div class="plano-card">
                                <h3><?= $plano['nome'] ?></h3>
                                <p><?= $plano['descricao'] ?></p>
                                <ul>
                                    <?php
                                    $beneficios = explode("\n", $plano['beneficios']);
                                    foreach ($beneficios as $b) echo "<li>$b</li>";
                                    ?>
                                </ul>
                                <p class="preco">R$ <?= number_format($plano['preco'], 2, ',', '.') ?>/mês</p>
                                <a href="assinar_plano.php?plano=<?= urlencode($plano['nome']) ?>" class="btn-assinar">Assinar</a>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </section>
            </div>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>