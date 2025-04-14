<?php
include 'db_connection.php';

$user_id = $_GET['id'];

// Atualiza o status do professor para 'ativo'
$sql = "UPDATE usuarios SET status = 'ativo' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Professor aprovado com sucesso!";
} else {
    echo "Erro ao aprovar o professor: " . $conn->error;
}

$stmt->close();
$conn->close();

// Redireciona para a lista de professores
header("Location: list_users.php?type=professor");
exit();
?>
