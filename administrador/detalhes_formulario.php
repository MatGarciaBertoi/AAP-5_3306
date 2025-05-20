<?php
session_start();
require '../funcoes/conexao.php'; // ajuste conforme necessário

// Verifica se o ID foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de formulário inválido.");
}

$id = (int) $_GET['id'];

// Busca o formulário
$sql = "SELECT * FROM formularios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Formulário não encontrado.");
}

$formulario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Formulário</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 15px;
        }

        .campo strong {
            display: inline-block;
            width: 200px;
        }

        a.voltar {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #007bff;
        }

        a.voltar:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include 'partials/header.php'; ?>

    <div class="container">
        <h2>Detalhes do Formulário #<?= $formulario['id'] ?></h2>

        <?php foreach ($formulario as $campo => $valor): ?>
            <?php if ($campo === 'id' || $campo === 'usuario_id') continue; ?>
            <div class="campo">
                <strong><?= ucfirst(str_replace("_", " ", $campo)) ?>:</strong> <?= nl2br(htmlspecialchars($valor)) ?>
            </div>
        <?php endforeach; ?>

        <a href="formularios.php" class="voltar">← Voltar para a lista de formulários</a>

        <form action="funcoes/exportar_csv.php" method="get" style="text-align: center; margin-top: 20px;">
            <input type="hidden" name="id" value="<?= $formulario['id'] ?>">
            <button type="submit">Exportar para CSV</button>
        </form>

    </div>

    <?php include 'partials/footer.php'; ?>
</body>

</html>

<?php
$stmt->close();
$conexao->close();
?>