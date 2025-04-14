<?php
include 'db_connection.php';

$course_id = $_GET['id'];

// Atualiza o status do curso para 'aprovado'
$sql = "UPDATE cursos SET status = 'aprovado' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);

if ($stmt->execute()) {
    echo "Curso aprovado com sucesso!";
} else {
    echo "Erro ao aprovar o curso: " . $conn->error;
}

$stmt->close();
$conn->close();

// Redireciona de volta para a listagem de cursos
header("Location: list_courses.php");
exit();
?>
