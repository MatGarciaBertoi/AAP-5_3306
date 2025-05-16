<?php
session_start();
include_once('../../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../../../cadastro_login/aluno/signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_id = $_SESSION['id'];
    $curso_id = intval($_POST['curso_id']);
    $comentario = trim($_POST['comentario']);

    if (!empty($comentario)) {
        // Verifica se já enviou feedback
        $stmt = $conexao->prepare("SELECT id FROM feedbacks WHERE aluno_id = ? AND curso_id = ?");
        $stmt->bind_param("ii", $aluno_id, $curso_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            $stmt = $conexao->prepare("INSERT INTO feedbacks (aluno_id, curso_id, comentario) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $aluno_id, $curso_id, $comentario);
            $stmt->execute();

            $_SESSION['mensagem_feedback'] = "✅ Obrigado pelo seu feedback!";
        } else {
            $_SESSION['mensagem_feedback'] = "⚠️ Você já enviou seu feedback para este curso.";
        }
    } else {
        $_SESSION['mensagem_feedback'] = "❌ O campo de comentário não pode estar vazio.";
    }

    header("Location: ../ver_conteudo.php?curso_id=" . $curso_id);
    exit();
}
?>
