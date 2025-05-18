<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: http://localhost/AAP-5_3306/cadastro_login/usuario/signin.php');
    exit;
}

$plano = $_GET['plano'] ?? 'Essencial';

// Recupera os dados do aluno da sessão
$alunoId = $_SESSION['id'];
$nomeAluno = $_SESSION['nome'] ?? '';
$emailAluno = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Marketing Digital</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/assinar.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?>
    </div>
    <main class="assinar-main">
        <?php
        $msg = $_GET['msg'] ?? '';
        $mensagens = [
            'campos_obrigatorios' => 'Todos os campos são obrigatórios.',
            'assinatura_existente' => 'Você já possui uma assinatura ativa.',
            'erro_ao_assinar' => 'Erro ao processar sua assinatura. Tente novamente.',
        ];
        if ($msg && isset($mensagens[$msg])) {
            echo "<div class='mensagem-erro'>{$mensagens[$msg]}</div>";
        }
        ?>

        <h2>Assinar Plano: <?= htmlspecialchars($plano) ?></h2>

        <form action="funcoes/processa_pagamento.php" method="POST">
            <input type="hidden" name="aluno_id" value="<?= htmlspecialchars($alunoId) ?>">
            <input type="hidden" name="plano" value="<?= htmlspecialchars($plano) ?>">

            <label>Nome completo:</label><br>
            <input type="text" name="nome" value="<?= htmlspecialchars($nomeAluno) ?>" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($emailAluno) ?>" required><br><br>

            <label>Celular:</label><br>
            <input type="text" name="celular" required><br><br>

            <label>CPF:</label><br>
            <input type="text" name="cpf" required><br><br>

            <label>Forma de pagamento:</label><br>
            <select name="forma_pagamento" required>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Pix">Pix</option>
                <option value="PayPal">PayPal</option>
            </select><br><br>

            <button type="submit">Finalizar Compra</button>
        </form>
    </main>
    <?php include 'partials/footer.php'; ?>
</body>

</html>
