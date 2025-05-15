<?php
session_start();
include_once('../../funcoes/conexao.php');
include_once('../../funcoes/config.php'); // Aqui está definido DEFAULT_PROFILE_PHOTO corretamente

if (!isset($_SESSION['usuario'])) {
    header('Location: http://localhost/AAP-5_3306/cadastro_login/aluno/signin.php');
    exit();
}

$usuario = $_SESSION['usuario'];

$sql = "SELECT photo FROM usuarios WHERE usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $currentPhoto = $row['photo'];

    if ($currentPhoto !== DEFAULT_PROFILE_PHOTO && !empty($currentPhoto)) {
        $caminhoFoto = $_SERVER['DOCUMENT_ROOT'] . $currentPhoto;

        if (file_exists($caminhoFoto)) {
            unlink($caminhoFoto);
        }
    }

    $update = "UPDATE usuarios SET photo = ? WHERE usuario = ?";
    $stmtUpdate = $conexao->prepare($update);
    $defaultPhoto = DEFAULT_PROFILE_PHOTO; // Variável intermediária
    $stmtUpdate->bind_param("ss", $defaultPhoto, $usuario);
    $stmtUpdate->execute();
}

header('Location: ../../aluno/profile.php');
exit();
