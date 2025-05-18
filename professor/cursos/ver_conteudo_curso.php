<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    die("Acesso negado. Faça login.");
}

$curso_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Buscar curso
$sqlCurso = "SELECT * FROM cursos WHERE id = ?";
$stmtCurso = $conexao->prepare($sqlCurso);
$stmtCurso->bind_param("i", $curso_id);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();
$curso = $resultCurso->fetch_assoc();

if (!$curso) {
    die("Curso não encontrado.");
}

// Buscar aulas
$sqlAulas = "SELECT * FROM aulas WHERE curso_id = ? ORDER BY criado_em DESC";
$stmtAulas = $conexao->prepare($sqlAulas);
$stmtAulas->bind_param("i", $curso_id);
$stmtAulas->execute();
$aulas = $stmtAulas->get_result();

// Buscar provas e atividades (se tabela já existir)
$sqlAvaliacoes = "SELECT * FROM avaliacoes WHERE curso_id = ? ORDER BY data_criacao DESC";
$stmtAval = $conexao->prepare($sqlAvaliacoes);
$stmtAval->bind_param("i", $curso_id);
$stmtAval->execute();
$avaliacoes = $stmtAval->get_result();

$mensagemErro = '';
if (isset($_GET['erro']) && $_GET['erro'] === 'ja_tem_prova') {
    $mensagemErro = '⚠️ Este curso já possui uma prova criada por você.';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Conteúdo do Curso - <?php echo htmlspecialchars($curso['nome']); ?></title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="css/ver_conteudo.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">

        <?php if ($mensagemErro): ?>
            <div style="background-color: #ffdddd; color: #d8000c; padding: 10px; margin-bottom: 15px; border-left: 6px solid #f44336;">
                <?= $mensagemErro ?>
            </div>
        <?php endif; ?>
        <h1><?php echo htmlspecialchars($curso['nome']); ?></h1>
        <p><?php echo htmlspecialchars($curso['descricao']); ?></p>

        <div class="tabs">
            <button class="tab-btn active" data-tab="aulas">Aulas</button>
            <button class="tab-btn" data-tab="avaliacoes">Atividades e Provas</button>
        </div>

        <div id="aulas" class="tab-content active">
            <!-- Botão para abrir o formulário -->
            <button id="btnNovaAula" style="margin: 10px 0; padding: 8px 16px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Adicionar nova aula
            </button>

            <!-- Formulário oculto por padrão -->
            <div id="formNovaAula" style="display: none; margin-top: 10px;">
                <form action="funcoes/adicionar_aula.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                    <input type="hidden" name="curso_id" value="<?= $curso['id']; ?>">

                    <label for="titulo_aula">Título da Aula:</label>
                    <input type="text" name="titulo" id="titulo_aula" required>

                    <label for="conteudo">Conteúdo:</label>
                    <textarea name="conteudo" id="conteudo" rows="4" required></textarea>

                    <label for="video_url">URL do Vídeo (YouTube ou outro):</label>
                    <input type="url" name="video_url" id="video_url" placeholder="https://..." required>

                    <button type="submit" style="background-color: #2ecc71; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer;">
                        Cadastrar Aula
                    </button>
                </form>
            </div>

            <?php if ($aulas->num_rows > 0): ?>
                <?php while ($aula = $aulas->fetch_assoc()): ?>
                    <div class="item-card">
                        <strong><?php echo htmlspecialchars($aula['titulo']); ?></strong>
                        <p><?php echo mb_strimwidth(strip_tags($aula['conteudo']), 0, 100, '...'); ?></p>
                        <p><strong>Vídeo:</strong> <a href="<?= htmlspecialchars($aula['video_url']) ?>" target="_blank">Assistir</a></p>
                        <p><em>Criado em: <?= date('d/m/Y H:i', strtotime($aula['criado_em'])) ?></em></p>

                        <div class="acoes-aula">
                            <a href="editar_aula.php?id=<?= $aula['id'] ?>" class="btn-editar">✏️ Editar</a>
                            <a href="funcoes/excluir_aula.php?id=<?= $aula['id'] ?>"
                                class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta aula?');">🗑️ Excluir</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Este curso ainda não possui aulas cadastradas.</p>
            <?php endif; ?>
        </div>

        <div id="avaliacoes" class="tab-content">
            <!-- Botão para abrir o formulário -->
            <button id="btnNovaAvaliacao" style="margin: 10px 0; padding: 8px 16px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Adicionar nova prova/atividade
            </button>

            <!-- Formulário oculto por padrão -->
            <div id="formNovaAvaliacao" style="display: none; margin-top: 10px;">
                <form action="funcoes/adicionar_avaliacao.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                    <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">

                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" required>

                    <label for="tipo">Tipo:</label>
                    <select name="tipo" id="tipo" required>
                        <option value="">Selecione...</option>
                        <option value="Prova">Prova</option>
                        <option value="Atividade">Atividade</option>
                    </select>

                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" rows="4" required></textarea>

                    <button type="submit" style="background-color: #2ecc71; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer;">
                        Cadastrar
                    </button>
                </form>
            </div>
            <?php if ($avaliacoes->num_rows > 0): ?>
                <?php while ($avaliacao = $avaliacoes->fetch_assoc()): ?>
                    <div class="item-card">
                        <strong><?php echo htmlspecialchars($avaliacao['titulo']); ?> (<?php echo $avaliacao['tipo']; ?>)</strong>
                        <p><?php echo mb_strimwidth(strip_tags($avaliacao['descricao']), 0, 100, '...'); ?></p>
                        <p style="font-size: 0.85em; color: gray;">Criado em: <?php echo date('d/m/Y H:i', strtotime($avaliacao['data_criacao'])); ?></p>
                        <a href="ver_questoes.php?avaliacao_id=<?php echo $avaliacao['id']; ?>"
                            style="display: inline-block; margin-top: 6px; padding: 6px 12px; background-color:rgb(230, 201, 34); color: white; border-radius: 4px; text-decoration: none;">
                            Ver Questões
                        </a>
                        <a href="editar_avaliacao.php?avaliacao_id=<?php echo $avaliacao['id']; ?>"
                            style="display: inline-block; margin-top: 6px; padding: 6px 12px; background-color:rgb(230, 168, 34); color: white; border-radius: 4px; text-decoration: none;">
                            Editar
                        </a>
                        <a href="funcoes/remover_avaliacao.php?id=<?php echo $avaliacao['id']; ?>" style="color: red;" onclick="return confirm('Tem certeza que deseja excluir?');">Remover</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhuma atividade ou prova cadastrada ainda.</p>
            <?php endif; ?>

        </div>
    </div>
    <script>
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });
    </script>

    <script>
        document.getElementById('btnNovaAula').addEventListener('click', function() {
            const form = document.getElementById('formNovaAula');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <script>
        document.getElementById('btnNovaAvaliacao').addEventListener('click', function() {
            const form = document.getElementById('formNovaAvaliacao');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>

</body>

</html>