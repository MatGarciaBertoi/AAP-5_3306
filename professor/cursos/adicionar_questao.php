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
$sql = "SELECT curso_id, tipo FROM avaliacoes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $avaliacao_id);
$stmt->execute();
$result = $stmt->get_result();
$avaliacao = $result->fetch_assoc();

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}

$curso_id = $avaliacao['curso_id'];
$tipo_avaliacao = $avaliacao['tipo'];
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
    <div class="container">
        <h1>Adicionar Nova Questão</h1>

        <form id="formQuestao" action="funcoes/salvar_questao.php" method="POST" novalidate>
            <input type="hidden" name="avaliacao_id" value="<?php echo $avaliacao_id; ?>">

            <label>Enunciado:</label><br>
            <textarea name="enunciado" rows="5" cols="60" required></textarea><br><br>

            <label>Tipo de questão:</label>
            <select name="tipo" id="tipo" required onchange="toggleAlternativas()">
                <?php if ($tipo_avaliacao === 'Atividade'): ?>
                    <option value="dissertativa">Dissertativa</option>
                    <option value="multipla_escolha">Múltipla Escolha</option>
                <?php else: ?>
                    <option value="multipla_escolha" selected>Múltipla Escolha</option>
                <?php endif; ?>
            </select>
            <br><br>

            <div id="alternativas-box" style="display: none;">
                <label>Alternativas:</label><br>
                <input type="text" name="alternativas[]" placeholder="Alternativa A" required><br>
                <input type="text" name="alternativas[]" placeholder="Alternativa B" required><br>
                <input type="text" name="alternativas[]" placeholder="Alternativa C"><br>
                <input type="text" name="alternativas[]" placeholder="Alternativa D"><br><br>

                <label>Resposta correta (letra exata, ex: A, B, C ou D):</label><br>
                <input type="text" name="resposta_correta_mc" maxlength="1" pattern="[ABCDabcd]" required><br><br>
            </div>

            <div id="resposta-dissertativa-box" style="display: none;">
                <label>Resposta esperada:</label><br>
                <textarea name="resposta_correta_dissertativa" rows="4" cols="60" required></textarea><br><br>
            </div>

            <button type="submit">Salvar Questão</button>
            <a href="ver_questoes.php?avaliacao_id=<?php echo $avaliacao_id; ?>" class="btn-voltar">Voltar</a>
        </form>
    </div>

    <script>
        const tipoAvaliacao = "<?php echo $tipo_avaliacao; ?>";
        const tipoSelect = document.getElementById("tipo");
        const alternativasBox = document.getElementById("alternativas-box");
        const respostaDissertativaBox = document.getElementById("resposta-dissertativa-box");
        const form = document.getElementById("formQuestao");

        function toggleAlternativas() {
            const tipo = tipoSelect.value;
            if (tipo === "multipla_escolha") {
                alternativasBox.style.display = "block";
                respostaDissertativaBox.style.display = "none";
                alternativasBox.querySelectorAll('input[name="alternativas[]"]').forEach((input, index) => {
                    input.required = (index === 0 || index === 1);
                });
                alternativasBox.querySelector('input[name="resposta_correta_mc"]').required = true;
                respostaDissertativaBox.querySelector('textarea[name="resposta_correta_dissertativa"]').required = false;
            } else {
                alternativasBox.style.display = "none";
                respostaDissertativaBox.style.display = "block";
                alternativasBox.querySelectorAll('input[name="alternativas[]"]').forEach(input => input.required = false);
                alternativasBox.querySelector('input[name="resposta_correta_mc"]').required = false;
                respostaDissertativaBox.querySelector('textarea[name="resposta_correta_dissertativa"]').required = true;
            }
        }

        window.onload = () => {
            if (tipoAvaliacao === "Prova") {
                tipoSelect.value = "multipla_escolha";
                tipoSelect.disabled = true;
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "tipo";
                hiddenInput.value = "multipla_escolha";
                form.appendChild(hiddenInput);
            }
            toggleAlternativas();
        };

        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                alert("Por favor, preencha todos os campos obrigatórios corretamente.");
                return;
            }
            if (tipoSelect.value === 'multipla_escolha') {
                const alternativas = Array.from(form.querySelectorAll('input[name="alternativas[]"]')).map(i => i.value.trim());
                const preenchidas = alternativas.filter(a => a !== "");
                if (preenchidas.length < 2) {
                    e.preventDefault();
                    alert("Informe pelo menos duas alternativas preenchidas para a questão de múltipla escolha.");
                    return;
                }
                const resposta = form.querySelector('input[name="resposta_correta_mc"]').value.trim().toUpperCase();
                if (!['A', 'B', 'C', 'D'].includes(resposta)) {
                    e.preventDefault();
                    alert("Informe uma resposta correta válida (A, B, C ou D).");
                    return;
                }
                const indiceResposta = resposta.charCodeAt(0) - 65;
                if (!alternativas[indiceResposta]) {
                    e.preventDefault();
                    alert(`A alternativa correspondente à resposta correta (${resposta}) não está preenchida.`);
                    return;
                }
            }
        });
    </script>
</body>

</html>
