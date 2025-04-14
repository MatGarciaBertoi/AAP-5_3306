<?php
include 'db_connection.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'aluno'; // Define o tipo como aluno por padrão

$sql = "SELECT * FROM usuarios WHERE tipo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();

echo "<div class='page-container'>";  // Container para centralizar o título e os cards
// Ajuste no título
$tipoPlural = '';
switch ($type) {
    case 'administrador':
        $tipoPlural = 'Administradores';
        break;
    case 'professor':
        $tipoPlural = 'Professores';
        break;
    case 'aluno':
    default:
        $tipoPlural = 'Alunos';
        break;
}
echo "<h3 class='page-title'>" . $tipoPlural . " Listados</h3>";  // Nome da página centralizado

if ($result->num_rows > 0) {
    echo '<div class="user-cards">'; // Container para os cards
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<h3>" . $row['nome'] . "</h3>";
        echo "<p>Email: " . $row['email'] . "</p>";

        // Se o tipo for administrador, exibe o status e as ações
        if ($type == 'administrador') {
            echo "<p>Status: " . ucfirst($row['status']) . "</p>";  // Exibe o status do administrador

            // Botão para ver dados
            echo "<a href='view_user.php?id=" . $row['id'] . "' class='btn btn-info'>Ver Dados</a>";

            // Botão para deletar
            echo "<button class='btn-delete' onclick=\"deleteUser(" . $row['id'] . ")\">Deletar</button>";

            // Botão para bloquear/desbloquear com base no status atual
            if ($row['status'] == 'ativo') {
                echo "<button class='btn-block' onclick=\"blockUser(" . $row['id'] . ")\">Bloquear</button>";
            } else {
                echo "<button class='btn-success' onclick=\"unblockUser(" . $row['id'] . ")\">Desbloquear</button>";
            }
        } elseif ($type == 'professor') {
            echo "<p>Status: " . ucfirst($row['status']) . "</p>";  // Exibe o status do professor

            // Se o professor estiver pendente, mostra o botão "Aprovar"
            if ($row['status'] == 'pendente') {
                echo "<button class='btn-approve' onclick=\"approveUser(" . $row['id'] . ")\">Aprovar</button>";
            }

            // Se o professor estiver ativo, mostra o botão "Bloquear"
            if ($row['status'] == 'ativo') {
                echo "<button class='btn-block' onclick=\"blockUser(" . $row['id'] . ")\">Bloquear</button>";
            } else {
                // Se o professor estiver bloqueado, mostra o botão "Desbloquear"
                echo "<button class='btn-success' onclick=\"unblockUser(" . $row['id'] . ")\">Desbloquear</button>";
            }

            // Botão de deletar disponível para todos os professores
            echo "<button class='btn-delete' onclick=\"deleteUser(" . $row['id'] . ")\">Deletar</button>";
            echo "<a href='view_user.php?id=" . $row['id'] . "' class='btn btn-info'>Ver Dados</a>";
        }

        // Se o tipo for aluno, exibe apenas o botão de deletar e ver mais informações
        if ($type == 'aluno') {
            echo "<button class='btn-delete' onclick=\"deleteUser(" . $row['id'] . ")\">Deletar</button>";
            echo "<button class='btn-more' onclick=\"toggleDetails(" . $row['id'] . ")\">Ver Mais</button>";
            echo "<div class='user-details' id='details-" . $row['id'] . "' style='display: none;'>";
            echo "<p><strong>Endereço:</strong> " . $row['endereco'] . "</p>";
            echo "<p><strong>Telefone:</strong> " . $row['telefone'] . "</p>";
            echo "<p><strong>Data de Cadastro:</strong> " . $row['data_cadastro'] . "</p>";
            echo "</div>";
        }

        echo "</div>"; // Fecha o card
    }
    echo '</div>'; // Fecha o container dos cards
} else {
    echo "Nenhum " . $type . " encontrado.";
}

$conn->close();
?>

<script>
// Função para aprovar o professor
function approveUser(userId) {
    if (confirm('Tem certeza que deseja aprovar este professor?')) {
        window.location.href = 'approve_user.php?id=' + userId;
    }
}

// Função para bloquear o professor
function blockUser(userId) {
    if (confirm('Tem certeza que deseja bloquear este professor?')) {
        window.location.href = 'block_user.php?id=' + userId; // Redireciona para o arquivo de bloqueio
    }
}

// Função para desbloquear o professor
function unblockUser(userId) {
    if (confirm('Tem certeza que deseja desbloquear este professor?')) {
        window.location.href = 'unblock_user.php?id=' + userId; // Redireciona para o arquivo de desbloqueio
    }
}

// Função para deletar um usuário (aluno ou professor)
function deleteUser(userId) {
    if (confirm('Tem certeza que deseja deletar este usuário?')) {
        window.location.href = 'delete_user.php?id=' + userId;
    }
}

// Função para exibir ou ocultar detalhes do aluno
function toggleDetails(userId) {
    const details = document.getElementById('details-' + userId);
    if (details.style.display === 'none') {
        details.style.display = 'block';
    } else {
        details.style.display = 'none';
    }
}
</script>


<style>
/* Estilização do container da página e centralização */
.page-container {
    display: flex;
    flex-direction: column;
    align-items: center;  /* Centraliza o título e os cards */
    margin-top: 20px;
}

/* Estilização do título da página */
.page-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

/* Estilização dos Cards e Botões */
.user-cards {
    display: flex;
    flex-direction: column;  /* Cards um embaixo do outro */
    gap: 15px;  /* Espaçamento entre os cards */
    align-items: center;  /* Centralizar os cards */
    margin-top: 20px;
    padding: 0;
}

.card {
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 400px;  /* Largura maior para aparência de lista */
    text-align: left;  /* Texto alinhado à esquerda */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 10px;
}

p {
    color: #555;
    font-size: 16px;
    margin-bottom: 20px;
}

/* Botões */
.btn-approve, .btn-delete, .btn-more, .btn-block, .btn-info, .btn-warning, .btn-success {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-right: 10px;
}

.btn-approve {
    background-color: #28a745;
    color: white;
}

.btn-approve:hover {
    background-color: #218838;
}

.btn-delete {
    background-color: #dc3545; /* Cor vermelha */
    color: white;
}

.btn-delete:hover {
    background-color: #c82333; /* Cor de hover mais escura */
}

.btn-block {
    background-color: #ffcc00;
    color: white;
}

.btn-block:hover {
    background-color: #e0b500;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-warning {
    background-color: #ffc107;
    color: white;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-more {
    background-color: #007bff;
    color: white;
}

.btn-more:hover {
    background-color: #0056b3;
}

/* Estilização dos detalhes do aluno */
.user-details {
    background-color: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}


</style>
