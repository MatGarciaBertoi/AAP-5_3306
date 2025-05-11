<?php
session_start();
include_once('../../funcoes/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../cadastro_login/aluno/signin.php');
    exit();
}

$usuario = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $uploadDir = '../../funcoes/uploads/profile/';
    $caminhoParaBanco = '../funcoes/uploads/profile/'; // Caminho que será salvo no banco

    // Garante que o diretório existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES['photo']['name']);
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('foto_') . '.' . $fileExt;

    $targetFile = $uploadDir . $newFileName;
    $caminhoParaSalvarNoBanco = $caminhoParaBanco . $newFileName;

    // Tipos de imagem permitidos
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($fileExt), $allowedTypes)) {
        die('Formato de imagem não permitido.');
    }

    // Faz upload e atualiza no banco
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        $sql = "UPDATE usuarios SET photo = ? WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $caminhoParaSalvarNoBanco, $usuario);
        $stmt->execute();

        header('Location: ../profile.php');
        exit();
    } else {
        echo 'Erro ao fazer upload da imagem.';
    }
} else {
    echo 'Nenhuma imagem enviada ou erro no envio.';
}
?>
