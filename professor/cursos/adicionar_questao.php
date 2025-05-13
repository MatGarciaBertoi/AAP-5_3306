<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
    die("Acesso negado.");
}

$avaliacao_id = isset($_GET['avaliacao_id']) ? (int) $_GET['avaliacao_id'] : 0;

if (!$avaliacao_id) {
    die("ID da avaliação inválido.");
}

// Buscar curso_id da avaliação
$sql = "SELECT curso_id FROM avaliacoes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $avaliacao_id);
$stmt->execute();
$result = $stmt->get_result();
$avaliacao = $result->fetch_assoc();

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}

$curso_id = $avaliacao['curso_id'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Questão</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <h1>Adicionar Nova Questão</h1>

    <form action="funcoes/salvar_questao.php" method="POST">
        <input type="hidden" name="avaliacao_id" value="<?php echo $avaliacao_id; ?>">

        <label>Enunciado:</label><br>
        <textarea name="enunciado" rows="5" cols="60" required></textarea><br><br>

        <label>Tipo de questão:</label>
        <select name="tipo" id="tipo" required onchange="toggleAlternativas()">
            <option value="dissertativa">Dissertativa</option>
            <option value="multipla_escolha">Múltipla Escolha</option>
        </select><br><br>

        <div id="alternativas-box" style="display: none;">
            <label>Alternativas:</label><br>
            <input type="text" name="alternativas[]" placeholder="Alternativa A"><br>
            <input type="text" name="alternativas[]" placeholder="Alternativa B"><br>
            <input type="text" name="alternativas[]" placeholder="Alternativa C"><br>
            <input type="text" name="alternativas[]" placeholder="Alternativa D"><br><br>

            <label>Resposta correta (letra exata, ex: A, B, C ou D):</label><br>
            <input type="text" name="resposta_correta" maxlength="1"><br><br>
        </div>

        <button type="submit">Salvar Questão</button>
        <a href="ver_questoes.php?avaliacao_id=<?php echo $avaliacao_id; ?>" class="btn-voltar">Voltar</a>
    </form>

    <script>
        function toggleAlternativas() {
            const tipo = document.getElementById("tipo").value;
            document.getElementById("alternativas-box").style.display =
                tipo === "multipla_escolha" ? "block" : "none";
        }

        // Executa ao carregar a página, caso o valor já esteja preenchido
        window.onload = toggleAlternativas;
    </script>
</body>

</html>