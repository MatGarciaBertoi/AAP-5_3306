<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'aapcw_cadastro';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = intval($_GET['id']);

// Exclusão do curso pelo ID
$sql = "DELETE FROM cursos WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Exibe uma mensagem de sucesso e redireciona
    echo "<script>
            alert('Curso deletado com sucesso');
            window.location.href = 'list_courses.php';
        </script>";
} else {
    // Exibe uma mensagem de erro e permanece na página
    echo "<script>
            alert('Erro ao deletar o curso: " . $conn->error . "');
            window.location.href = 'list_courses.php';
        </script>";
}

$conn->close();
?>
