<?php
session_start();
include_once('../conexao.php');
include_once('../config.php'); // Para pegar DEFAULT_PROFILE_PHOTO se precisar

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../cadastro_login/aluno/signin.php');
    exit();
}

$usuario = $_SESSION['usuario'];

// Verifica se o arquivo foi enviado corretamente
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['photo'];

    // Extensões e tipos MIME permitidos
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $tiposMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $tipoMime = mime_content_type($foto['tmp_name']);

    if (!in_array($extensao, $permitidos) || !in_array($tipoMime, $tiposMime)) {
        die("Formato de imagem inválido.");
    }

    $nomeUnico = uniqid('profile_', true) . '.' . $extensao;

    // Caminhos
    $pastaUpload = $_SERVER['DOCUMENT_ROOT'] . '/AAP-5_3306/funcoes/uploads/profile/';
    $caminhoCompleto = $pastaUpload . $nomeUnico;
    $caminhoRelativoBanco = '/AAP-5_3306/funcoes/uploads/profile/' . $nomeUnico;

    // Buscar foto antiga do usuário no banco
    $sqlFoto = "SELECT photo FROM usuarios WHERE usuario = ?";
    $stmtFoto = $conexao->prepare($sqlFoto);
    $stmtFoto->bind_param("s", $usuario);
    $stmtFoto->execute();
    $stmtFoto->bind_result($fotoAntiga);
    $stmtFoto->fetch();
    $stmtFoto->close();

    // Remove a foto antiga se não for a padrão
    if ($fotoAntiga && $fotoAntiga !== DEFAULT_PROFILE_PHOTO) {
        $caminhoAntigo = $_SERVER['DOCUMENT_ROOT'] . $fotoAntiga;
        if (file_exists($caminhoAntigo)) {
            unlink($caminhoAntigo);
        }
    }

    // Move a nova imagem para o destino
    if (move_uploaded_file($foto['tmp_name'], $caminhoCompleto)) {
        // Atualiza o caminho no banco
        $sql = "UPDATE usuarios SET photo = ? WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $caminhoRelativoBanco, $usuario);

        if ($stmt->execute()) {
            header("Location: ../../aluno/profile.php");
            exit();
        } else {
            echo "Erro ao atualizar a foto no banco de dados.";
        }
    } else {
        echo "Erro ao salvar a imagem no servidor.";
    }
} else {
    echo "Nenhuma imagem enviada ou erro no upload.";
}
