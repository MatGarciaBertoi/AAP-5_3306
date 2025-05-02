<?php
session_start();
include '../../../funcoes/conexao.php';
include '../funcoes/listagemUsuarios.php';

$type = $_GET['type'] ?? 'aluno';
$busca = $_GET['busca'] ?? '';
?>

<!-- HTML inicia -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($type) ?>es Cadastrados</title>
    <link rel="shortcut icon" href="../../../images/logotipocw.png" />
    <link rel="stylesheet" href="css/list.css">
    <link rel="stylesheet" href="../partials/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="container">
        <h2><?= ucfirst($type) ?>s Cadastrados</h2>

        <form method="GET" class="form-busca">
            <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
            <input type="text" name="busca" placeholder="Buscar por nome, email ou usuário..." value="<?= htmlspecialchars($busca) ?>">
            <button type="submit">Buscar</button>
        </form>

        <?php listarUsuarios($conexao, $type, $busca); ?>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
