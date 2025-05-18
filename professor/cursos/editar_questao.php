<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
    die("Acesso negado.");
}

$questao_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Buscar dados da questão
$sql = "SELECT * FROM questoes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $questao_id);
$stmt->execute();
$result = $stmt->get_result();
$questao = $result->fetch_assoc();

if (!$questao) {
    die("Questão não encontrada.");
}

$avaliacao_id = $questao['avaliacao_id'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Questão</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Editar Questão</h1>

        <form action="funcoes/atualizar_questao.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $questao_id; ?>">
            <input type="hidden" name="avaliacao_id" value="<?php echo $avaliacao_id; ?>">

            <label>Enunciado:</label><br>
            <textarea name="enunciado" rows="5" cols="60" required><?php echo htmlspecialchars($questao['enunciado'] ?? ''); ?></textarea><br><br>

            <label>Tipo de questão:</label>
            <select name="tipo" id="tipo" required onchange="toggleCampos()">
                <option value="dissertativa" <?php if (($questao['tipo'] ?? '') === 'dissertativa') echo 'selected'; ?>>Dissertativa</option>
                <option value="multipla_escolha" <?php if (($questao['tipo'] ?? '') === 'multipla_escolha') echo 'selected'; ?>>Múltipla Escolha</option>
            </select><br><br>

            <!-- Múltipla Escolha -->
            <div id="alternativas-box" style="display: none;">
                <label>Alternativas:</label><br>
                <?php
                $alternativas = [];
                if (!empty($questao['alternativas'])) {
                    $alternativas = json_decode($questao['alternativas'], true) ?? [];
                }
                $letras = ['A', 'B', 'C', 'D'];
                foreach ($letras as $index => $letra):
                    $valor = $alternativas[$index] ?? ''; // Corrigido para index numérico
                ?>
                    <input type="text" name="alternativas[]" placeholder="Alternativa <?php echo $letra; ?>" value="<?php echo htmlspecialchars($valor); ?>"><br>
                <?php endforeach; ?>
                <br>
                <label>Resposta correta (letra):</label><br>
                <input type="text" name="resposta_correta" maxlength="1" value="<?php echo htmlspecialchars($questao['resposta_correta'] ?? ''); ?>"><br><br>
            </div>

            <!-- Dissertativa -->
            <div id="resposta-dissertativa-box" style="display: none;">
                <label>Resposta esperada:</label><br>
                <textarea name="resposta_correta" rows="4" cols="60"><?php echo htmlspecialchars($questao['resposta_correta'] ?? ''); ?></textarea><br><br>
            </div>

            <button type="submit">Salvar Alterações</button>
            <a href="ver_questoes.php?avaliacao_id=<?php echo $avaliacao_id; ?>" class="btn-voltar">Voltar</a>
        </form>
    </div>
    <script>
        function toggleCampos() {
            const tipo = document.getElementById("tipo").value;
            document.getElementById("alternativas-box").style.display = tipo === "multipla_escolha" ? "block" : "none";
            document.getElementById("resposta-dissertativa-box").style.display = tipo === "dissertativa" ? "block" : "none";
        }

        window.onload = toggleCampos;
    </script>
</body>

</html>