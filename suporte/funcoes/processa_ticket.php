<?php
// Conexão com o banco
include '../../funcoes/conexao.php'; // ou ajuste o caminho correto

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os dados
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $assunto = $_POST['subject'];
    $mensagem = $_POST['message'];

    // Preparando e executando
    $stmt = $conexao->prepare("INSERT INTO tickets (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);

    if ($stmt->execute()) {
        // Pegando o ID do ticket gerado
        $ticket_id = $stmt->insert_id;
        echo "<div style='padding:20px; background-color: #d4edda; border-radius:10px; margin:20px 0;'>
                <i class='bi bi-check-circle-fill'></i> Ticket criado com sucesso!<br>
                Número do seu ticket: <strong>#{$ticket_id}</strong><br>
                Nossa equipe responderá em breve. 
              </div>";
    } else {
        echo "<div style='padding:20px; background-color: #f8d7da; border-radius:10px; margin:20px 0;'>
                <i class='bi bi-x-circle-fill'></i> Erro ao enviar ticket. Tente novamente mais tarde.
              </div>";
    }

    $stmt->close();
    $conexao->close();
} else {
    header("Location: http://localhost/AAP-CW_Cursos/suporte/ticket.php"); // Se acessarem diretamente
    exit();
}
?>