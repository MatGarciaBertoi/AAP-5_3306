<?php
session_start();
include '../../../funcoes/conexao.php';

$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? '';

if (!$id || !$type) {
    echo "Parâmetros inválidos.";
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = ? AND tipo = ?");
$stmt->bind_param("is", $id, $type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Usuário não encontrado.";
    exit;
}

$usuario = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $usuario_nome = $_POST['usuario'] ?? '';
    $status = $_POST['status'] ?? 'ativo';
    $senha = $_POST['senha'] ?? '';

    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conexao->prepare("UPDATE usuarios SET nome = ?, email = ?, usuario = ?, status = ?, senha = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nome, $email, $usuario_nome, $status, $senha_hash, $id);
    } else {
        $stmt = $conexao->prepare("UPDATE usuarios SET nome = ?, email = ?, usuario = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $usuario_nome, $status, $id);
    }

    $stmt->execute();
    header("Location: ../{$type}/list.php?type=$type");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar <?= ucfirst($type) ?></title>
    <link rel="shortcut icon" href="../../../images/logotipocw.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/editar.css">
    <link rel="stylesheet" href="../partials/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>
    <div class="container">
        <div class="edit">
            <h2>Editar <?= ucfirst($type) ?></h2>
            <form method="POST">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

                <label for="usuario">Usuário:</label>
                <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

                <label for="senha">Nova Senha (deixe em branco para não alterar):</label>
                <div class="senha-container">
                    <input type="password" name="senha" id="senha" placeholder="Nova senha">
                    <button type="button" class="toggle-senha" onclick="toggleSenha()">👁</button>
                </div>

                <label for="status">Status:</label>
                <select name="status">
                    <option value="ativo" <?= $usuario['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="pendente" <?= $usuario['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="bloqueado" <?= $usuario['status'] === 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                </select>

                <button type="submit">Salvar Alterações</button>
                <a href="../<?= $type ?>/list.php?type=<?= $type ?>">Cancelar</a>
            </form>
        </div>
    </div>
    <?php include '../partials/footer.php'; ?>
    <script>
        function toggleSenha() {
            const input = document.getElementById('senha');
            const button = document.querySelector('.toggle-senha');
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🙈';
            } else {
                input.type = 'password';
                button.textContent = '👁';
            }
        }
    </script>

</body>

</html>