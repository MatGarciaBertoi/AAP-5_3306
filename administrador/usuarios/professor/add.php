<?php
session_start();
include '../../../funcoes/conexao.php'; // ajuste o caminho conforme necessário

$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';

// Verifica se é para listar professores pendentes
if ($type === 'professor' && $status === 'pendente') {
    $query = "SELECT * FROM professores_voluntarios ORDER BY data_inscricao DESC";
    $result = mysqli_query($conexao, $query);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Professores Pendentes</title>
    <link rel="shortcut icon" href="../../../images/logotipocw.png" />
    <link rel="stylesheet" href="css/add.css">
    <link rel="stylesheet" href="partials/style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h2>Professores Pendentes</h2>

        <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Área de Conhecimento</th>
                        <th>Data de Inscrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nome']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['area_conhecimento']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['data_inscricao'])) ?></td>
                            <td>
                                <a href="detalhes.php?id=<?= $row['id'] ?>">Ver Detalhes</a>
                                <!-- aqui você pode adicionar botões para 'Aprovar' ou 'Excluir' -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum professor pendente encontrado.</p>
        <?php endif; ?>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>
</html>
