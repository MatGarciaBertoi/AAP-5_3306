<?php
// Inclui o arquivo de conexão
$conexao = require_once '../../funcoes/conexao.php'; // Ajuste o caminho se necessário

// Buscar as mensagens
$sql = "SELECT id, nome, email, assunto, mensagem, status, data_criacao FROM tickets ORDER BY data_criacao DESC";
$result = $conexao->query($sql);

// Verificar se encontrou resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Transformar o status em uma classe segura para CSS
        $classStatus = strtolower(str_replace(' ', '-', $row['status']));

        echo "<div class='message $classStatus'>";
        echo "<strong>Nome:</strong> " . htmlspecialchars($row['nome']) . "<br>";
        echo "<strong>Email:</strong> " . htmlspecialchars($row['email']) . "<br>";
        echo "<strong>Assunto:</strong> " . htmlspecialchars($row['assunto']) . "<br>";
        echo "<strong>Mensagem:</strong> " . nl2br(htmlspecialchars($row['mensagem'])) . "<br>";
        echo "<strong>Status:</strong> " . htmlspecialchars($row['status']) . "<br>";
        echo "<strong>Data:</strong> " . date('d/m/Y H:i', strtotime($row['data_criacao'])) . "<br>";
        echo "<button onclick=\"responderTicket({$row['id']})\">Responder</button>";
        echo "</div><br>";

        // Buscar respostas associadas (movido dentro do loop)
        $ticketId = $row['id'];
        $respostasSql = "SELECT resposta, data_resposta FROM respostas_tickets WHERE ticket_id = $ticketId ORDER BY data_resposta ASC";
        $respostasResult = $conexao->query($respostasSql);

        if ($respostasResult->num_rows > 0) {
            echo "<div class='respostas'>";
            echo "<h4>Respostas:</h4>";
            while ($resposta = $respostasResult->fetch_assoc()) {
                echo "<div class='resposta'>";
                echo "<p>" . nl2br(htmlspecialchars($resposta['resposta'])) . "</p>";
                echo "<small>Enviado em: " . date('d/m/Y H:i', strtotime($resposta['data_resposta'])) . "</small>";
                echo "</div>";
            }
            echo "</div>";
        }
    }
} else {
    echo "<p>Nenhuma mensagem encontrada.</p>";
}

$conexao->close();
?>