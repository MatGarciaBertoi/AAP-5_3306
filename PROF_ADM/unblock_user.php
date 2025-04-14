<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Atualiza o status do usuário para 'ativo'
    $sql = "UPDATE usuarios SET status = 'ativo' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Redireciona de volta à página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$conn->close();
?>
