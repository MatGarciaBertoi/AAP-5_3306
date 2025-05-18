<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
    die("Acesso negado.");
}

// Validar dados básicos
$avaliacao_id = isset($_POST['avaliacao_id']) ? (int) $_POST['avaliacao_id'] : 0;
$tipo = $_POST['tipo'] ?? '';
$enunciado = trim($_POST['enunciado'] ?? '');

if (!$avaliacao_id || !$tipo || empty($enunciado)) {
    die("Dados incompletos.");
}

// Validação e preparação
if ($tipo === 'multipla_escolha') {
    $alternativas = $_POST['alternativas'] ?? [];
    $resposta_correta = strtoupper(trim($_POST['resposta_correta_mc'] ?? ''));

    // Verificar se tem pelo menos duas alternativas preenchidas
    $alternativas_preenchidas = array_filter($alternativas, fn($alt) => trim($alt) !== '');
    if (count($alternativas_preenchidas) < 2) {
        die("É necessário preencher pelo menos duas alternativas.");
    }

    // Validar letra da resposta correta
    if (!in_array($resposta_correta, ['A', 'B', 'C', 'D'])) {
        die("A resposta correta deve ser A, B, C ou D.");
    }

    // Validar se a alternativa correspondente à resposta está preenchida
    $indice = ord($resposta_correta) - 65; // A=0, B=1, etc.
    if (!isset($alternativas[$indice]) || trim($alternativas[$indice]) === '') {
        die("A alternativa correspondente à resposta correta ($resposta_correta) não está preenchida.");
    }

    // Serializar as alternativas
    $alternativas_serializadas = json_encode(array_map('trim', $alternativas));
    $resposta_final = $resposta_correta;

} elseif ($tipo === 'dissertativa') {
    $resposta_dissertativa = trim($_POST['resposta_correta_dissertativa'] ?? '');
    if (empty($resposta_dissertativa)) {
        die("A resposta dissertativa não pode estar vazia.");
    }
    $alternativas_serializadas = null;
    $resposta_final = $resposta_dissertativa;
} else {
    die("Tipo de questão inválido.");
}

// Inserir no banco de dados
$sql = "INSERT INTO questoes (avaliacao_id, tipo, enunciado, alternativas, resposta_correta) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("issss", $avaliacao_id, $tipo, $enunciado, $alternativas_serializadas, $resposta_final);

if ($stmt->execute()) {
    header("Location: ../ver_questoes.php?avaliacao_id=$avaliacao_id");
    exit;
} else {
    die("Erro ao salvar a questão: " . $stmt->error);
}
?>
