<?php
session_start();
include '../funcoes/conexao.php'; // Inclui sua conexão

// Verifica se o aluno está logado
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header("Location: cadastro_login/signin.php");
    exit;
}

// Pega o ID do ticket pela URL
$ticketId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Se não tiver ID, volta
if ($ticketId <= 0) {
    echo "<p>Ticket inválido.</p>";
    exit;
}

// Confere se o ticket pertence ao aluno logado (por email)
$stmt = $conexao->prepare("
    SELECT t.id, t.assunto, t.mensagem, t.status, t.data_criacao
    FROM tickets t
    INNER JOIN usuarios u ON t.email = u.email
    WHERE t.id = ? AND u.id = ?
");
$stmt->bind_param("ii", $ticketId, $_SESSION['id']);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "<p>Ticket não encontrado ou não é seu.</p>";
    exit;
}

$ticket = $resultado->fetch_assoc();
$stmt->close();

// Busca as respostas relacionadas a esse ticket
$stmtRespostas = $conexao->prepare("
    SELECT resposta, data_resposta
    FROM respostas_tickets
    WHERE ticket_id = ?
    ORDER BY data_resposta ASC
");
$stmtRespostas->bind_param("i", $ticketId);
$stmtRespostas->execute();
$respostas = $stmtRespostas->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CW Cursos - Suporte</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/ver_ticket.css">
</head>

<body>
    <header class="navbar">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </header>

    <main>
        <div class="ticket-detalhes">
            <h1>Assunto: <?php echo htmlspecialchars($ticket['assunto']); ?></h1>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($ticket['status']); ?></p>
            <p><strong>Enviado em:</strong> <?php echo date('d/m/Y H:i', strtotime($ticket['data_criacao'])); ?></p>
            <div class="ticket-mensagem">
                <h2>Mensagem:</h2>
                <p><?php echo nl2br(htmlspecialchars($ticket['mensagem'])); ?></p>
            </div>

            <div class="ticket-respostas">
                <h2>Respostas:</h2>
                <?php if ($respostas->num_rows > 0): ?>
                    <?php while ($resposta = $respostas->fetch_assoc()): ?>
                        <div class="resposta-item">
                            <p><?php echo nl2br(htmlspecialchars($resposta['resposta'])); ?></p>
                            <small>Respondido em: <?php echo date('d/m/Y H:i', strtotime($resposta['data_resposta'])); ?></small>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Ainda não houve resposta.</p>
                <?php endif; ?>
            </div>

            <a href="meusTickets.php" class="btn-voltar">Voltar</a>
        </div>
    </main>
    <?php include 'partials/footer.php'; ?>

</body>

</html>

<?php
$stmtRespostas->close();
$conexao->close();
?>