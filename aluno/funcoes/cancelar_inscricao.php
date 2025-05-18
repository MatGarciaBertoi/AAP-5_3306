<?php
session_start();
include_once('../../funcoes/conexao.php');

// Garante que só alunos possam cancelar
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: http://localhost/AAP-CW_Cursos/cadastro_login/usuario/signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscricao_id'])) {
    $inscricao_id = intval($_POST['inscricao_id']);
    $aluno_id = $_SESSION['id'];

    // Verifica se essa inscrição pertence ao aluno logado
    $verifica = $conexao->prepare("SELECT * FROM inscricoes WHERE id = ? AND aluno_id = ?");
    $verifica->bind_param("ii", $inscricao_id, $aluno_id);
    $verifica->execute();
    $resultado = $verifica->get_result();

    if ($resultado->num_rows > 0) {
        $stmt = $conexao->prepare("DELETE FROM inscricoes WHERE id = ?");
        $stmt->bind_param("i", $inscricao_id);
        if ($stmt->execute()) {
            header("Location: ../areadoaluno.php?msg=inscricao_cancelada");
            exit();
        } else {
            echo "Erro ao cancelar inscrição.";
        }
    } else {
        echo "Inscrição não encontrada ou não pertence a você.";
    }
} else {
    echo "Requisição inválida.";
}
?>
