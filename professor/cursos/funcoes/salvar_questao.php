<?php
require_once '../../../funcoes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avaliacao_id = (int) $_POST['avaliacao_id'];
    $enunciado = trim($_POST['enunciado']);
    $tipo = $_POST['tipo'];
    $resposta_correta = isset($_POST['resposta_correta']) ? trim($_POST['resposta_correta']) : null;

    if ($tipo === 'multipla_escolha') {
        $alternativas = array_map('trim', $_POST['alternativas']);
        $alternativasJson = json_encode($alternativas, JSON_UNESCAPED_UNICODE);
    } else {
        $alternativasJson = null;
        $resposta_correta = null; // A resposta será avaliada manualmente
    }

    $sql = "INSERT INTO questoes (avaliacao_id, enunciado, tipo, alternativas, resposta_correta) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("issss", $avaliacao_id, $enunciado, $tipo, $alternativasJson, $resposta_correta);

    if ($stmt->execute()) {
        header("Location: ../adicionar_questao.php?avaliacao_id=" . $avaliacao_id);
        exit;
    } else {
        echo "Erro ao salvar a questão: " . $stmt->error;
    }
} else {
    echo "Requisição inválida.";
}
