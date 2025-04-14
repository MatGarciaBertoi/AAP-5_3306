<?php
include 'db_connection.php';

// Verifica se os dados foram enviados corretamente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome_curso'], $_POST['descricao'], $_POST['duracao'])) {
    $nome_curso = $_POST['nome_curso'];
    $descricao = $_POST['descricao'];
    $duracao = $_POST['duracao'];
    $imagem = null;
    $video_url = null;

    // Verifica e processa o upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_dir = 'uploads/imagens/';
        $imagem_name = uniqid() . '_' . basename($_FILES['imagem']['name']);
        $imagem_path = $imagem_dir . $imagem_name;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)) {
            $imagem = $imagem_path;
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem');</script>";
        }
    }

    // Verifica e processa o upload ou URL do vídeo
    if (!empty($_POST['video_url'])) {
        $video_url = $_POST['video_url'];
    } elseif (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == 0) {
        $video_dir = 'uploads/videos/';
        $video_name = uniqid() . '_' . basename($_FILES['video_file']['name']);
        $video_path = $video_dir . $video_name;

        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $video_path)) {
            $video_url = $video_path;
        } else {
            echo "<script>alert('Erro ao fazer upload do vídeo');</script>";
        }
    }

    // Prepara a consulta SQL para adicionar o curso
    $sql = "INSERT INTO cursos (nome_curso, descricao, duracao, imagem, video_url, status) VALUES (?, ?, ?, ?, ?, 'pendente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $nome_curso, $descricao, $duracao, $imagem, $video_url);

    if ($stmt->execute()) {
        echo "<script>
                alert('Curso adicionado com sucesso!');
                window.location.href = 'list_courses.php';
                </script>";
    } else {
        echo "<script>
                alert('Erro ao adicionar curso: " . $conn->error . "');
                window.location.href = 'list_courses.php';
                </script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Erro: Dados do formulário estão incompletos ou ausentes.');</script>";
}

$conn->close();
?>
