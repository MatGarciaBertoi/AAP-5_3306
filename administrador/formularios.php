<?php
session_start();
require '../funcoes/conexao.php';

// Verifica se foi enviado termo de busca
$termo = isset($_GET['busca']) ? trim($_GET['busca']) : '';

// Query com ou sem filtro
if ($termo !== '') {
    $sql = "SELECT * FROM formularios 
            WHERE nome LIKE ? OR email LIKE ? OR tipo_curso LIKE ? 
            ORDER BY data_envio DESC";
    $stmt = $conexao->prepare($sql);
    $likeTerm = '%' . $termo . '%';
    $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM formularios ORDER BY data_envio DESC";
    $result = $conexao->query($sql);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração - Formulários</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .container {
            padding: 20px;
            max-width: 95%;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
        }

        form.pesquisa-form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            width: 300px;
            font-size: 16px;
        }

        button {
            padding: 8px 12px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="container">
        <h2>Formulários Enviados</h2>

        <!-- Formulário de pesquisa -->
        <form method="GET" class="pesquisa-form">
            <input type="text" name="busca" placeholder="Buscar por nome, email ou curso" value="<?= htmlspecialchars($termo) ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Email</th>
                        <th>Experiência</th>
                        <th>Avaliação</th>
                        <th>Navegação</th>
                        <th>Qualidade</th>
                        <th>Atendimento</th>
                        <th>Tipo de Curso</th>
                        <th>Data</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['nome']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['experiencia']) ?></td>
                            <td><?= htmlspecialchars($row['avaliacao_experiencia']) ?></td>
                            <td><?= htmlspecialchars($row['navegacao']) ?></td>
                            <td><?= htmlspecialchars($row['qualidade']) ?></td>
                            <td><?= htmlspecialchars($row['atendimento']) ?></td>
                            <td><?= htmlspecialchars($row['tipo_curso']) ?></td>
                            <td><?= $row['data_envio'] ?></td>
                            <td><a href="detalhes_formulario.php?id=<?= $row['id'] ?>">Ver</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center;">Nenhum formulário encontrado.</p>
        <?php endif; ?>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>
</html>

<?php
if (isset($stmt)) $stmt->close();
$conexao->close();
?>
