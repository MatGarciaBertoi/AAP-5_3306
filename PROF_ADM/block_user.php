<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Atualiza o status do usuário para 'bloqueado'
    $sql = "UPDATE usuarios SET status = 'bloqueado' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Redireciona de volta à página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$conn->close();
?>
