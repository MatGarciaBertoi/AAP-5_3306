<?php
include 'db_connection.php';

$user_id = $_GET['id'];

// Deletar o usuário do banco de dados
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Usuário deletado com sucesso!";
} else {
    echo "Erro ao deletar o usuário: " . $conn->error;
}

$stmt->close();
$conn->close();

// Redireciona de volta para a listagem de professores
header("Location: list_users.php?type=professor");
exit();
?>
