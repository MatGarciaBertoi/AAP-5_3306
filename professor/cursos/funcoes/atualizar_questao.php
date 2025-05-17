<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Requisição inválida.");
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$avaliacao_id = isset($_POST['avaliacao_id']) ? (int) $_POST['avaliacao_id'] : 0;
$enunciado = trim($_POST['enunciado'] ?? '');
$tipo = $_POST['tipo'] ?? '';

if (empty($enunciado) || empty($tipo)) {
    die("Todos os campos obrigatórios devem ser preenchidos.");
}

$alternativas_json = null;
$resposta_correta = null;

if ($tipo === 'multipla_escolha') {
    $alternativas = $_POST['alternativas'] ?? [];
    $resposta_correta = strtoupper(trim($_POST['resposta_correta'] ?? ''));

    $letras = ['A', 'B', 'C', 'D'];
    $alternativas_formatadas = [];

    foreach ($letras as $index => $letra) {
        $texto = trim($alternativas[$index] ?? '');
        if ($texto === '') {
            die("A alternativa $letra não pode estar vazia.");
        }
        $alternativas_formatadas[$letra] = $texto;
    }

    if (!array_key_exists($resposta_correta, $alternativas_formatadas)) {
        die("A resposta correta deve ser uma letra entre A e D.");
    }

    $alternativas_json = json_encode($alternativas_formatadas, JSON_UNESCAPED_UNICODE);
} elseif ($tipo === 'dissertativa') {
    $resposta_correta = trim($_POST['resposta_correta'] ?? '');
    if ($resposta_correta === '') {
        die("A resposta esperada não pode estar vazia para questões dissertativas.");
    }
    $alternativas_json = null; // Nenhuma alternativa é usada
}

// Atualizar no banco de dados
$sql = "UPDATE questoes SET enunciado = ?, tipo = ?, alternativas = ?, resposta_correta = ? WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param(
    "ssssi",
    $enunciado,
    $tipo,
    $alternativas_json,
    $resposta_correta,
    $id
);

if ($stmt->execute()) {
    header("Location: ../ver_questoes.php?avaliacao_id=$avaliacao_id");
    exit;
} else {
    echo "Erro ao atualizar a questão: " . $stmt->error;
}
?>
