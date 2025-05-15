<?php
session_start();
include_once('../funcoes/conexao.php');
include_once('../funcoes/config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: http://localhost/AAP-CW_Cursos/cadastro_login/aluno/signin.php');
    exit();
}

$usuario = $_SESSION['usuario'];

// Consulta única para buscar dados do usuário
$sql = "SELECT id, nome, photo, email, data_nascimento FROM usuarios WHERE usuario = ?";
$stmt = $conexao->prepare($sql);
if (!$stmt) {
    die("Erro ao preparar statement: " . $conexao->error);
}
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Usuário não encontrado.");
}

$nome = $row['nome']; // <-- Adicione isso
$profile_photo = !empty($row['photo']) ? $row['photo'] : DEFAULT_PROFILE_PHOTO;
$email = $row['email'];
$data_nascimento = $row['data_nascimento'];
$aluno_id = $row['id'];

// Busca cursos concluídos
$sqlConcluidos = "SELECT c.nome, cc.data_conclusao FROM cursos c
                  INNER JOIN cursos_concluidos cc ON cc.curso_id = c.id
                  WHERE cc.aluno_id = ?";
$stmtConcluidos = $conexao->prepare($sqlConcluidos);
$stmtConcluidos->bind_param("i", $aluno_id);
$stmtConcluidos->execute();
$resultConcluidos = $stmtConcluidos->get_result();

// Consulta para calcular o progresso atual por curso
$sqlProgresso = "
    SELECT 
        c.id AS curso_id,
        c.nome AS curso_nome,
        COUNT(a.id) AS total_aulas,
        SUM(CASE WHEN pa.concluida = 1 THEN 1 ELSE 0 END) AS aulas_concluidas
    FROM cursos c
    JOIN aulas a ON c.id = a.curso_id
    LEFT JOIN progresso_aula pa ON pa.aula_id = a.id AND pa.aluno_id = ?
    GROUP BY c.id, c.nome
";
$stmtProgresso = $conexao->prepare($sqlProgresso);
$stmtProgresso->bind_param("i", $aluno_id);
$stmtProgresso->execute();
$resultProgresso = $stmtProgresso->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - Cursos</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>

    <div class="profile-container">
        <!-- Ícone de engrenagem -->
        <div class="settings-icon" onclick="togglePersonalData()">⚙️</div>

        <!-- Foto do perfil -->
        <div class="profile-photo">
            <img src="<?= htmlspecialchars($profile_photo) ?>" alt="Foto do Usuário" id="userPhoto">
        </div>

        <!-- Upload de foto -->
        <div class="upload-section">
            <form action="../funcoes/usuario/upload_photo.php" method="post" enctype="multipart/form-data">
                <input type="file" name="photo" id="upload" accept="image/*">
                <label for="upload" class="upload-label">Carregar nova foto</label>
                <input type="submit" value="Salvar Foto" class="upload-btn">
            </form>
            <form action="../funcoes/usuario/remover_foto.php" method="post" onsubmit="return confirm('Tem certeza que deseja remover sua foto atual e voltar à padrão?');">
                <input type="submit" value="Remover Foto" class="upload-btn" style="background-color: #e74c3c;">
            </form>
        </div>

        <!-- Informações -->
        <div class="profile-info">
            <h1><?= htmlspecialchars($usuario) ?></h1>
            <p>Bem-vindo ao seu perfil, aqui verá seu progresso em nossa plataforma!</p>
        </div>

        <!-- Navegação -->
        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'CursosConcluidos')">Cursos Concluídos</button>
            <button class="tablinks" onclick="openTab(event, 'ProgressoAtual')">Progresso Atual</button>
        </div>

        <!-- Aba: Cursos Concluídos -->
        <div id="CursosConcluidos" class="tabcontent active">
            <div class="course-list">
                <?php if ($resultConcluidos->num_rows > 0): ?>
                    <?php while ($curso = $resultConcluidos->fetch_assoc()): ?>
                        <div class="course-item">
                            <h3><?= htmlspecialchars($curso['nome']) ?></h3>
                            <p>Concluído em: <?= date('d/m/Y', strtotime($curso['data_conclusao'])) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você ainda não concluiu nenhum curso.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Aba: Progresso Atual (exemplo estático) -->
        <div id="ProgressoAtual" class="tabcontent">
            <div class="course-list">
                <?php if ($resultProgresso->num_rows > 0): ?>
                    <?php while ($curso = $resultProgresso->fetch_assoc()):
                        $total = (int)$curso['total_aulas'];
                        $concluidas = (int)$curso['aulas_concluidas'];
                        $porcentagem = $total > 0 ? round(($concluidas / $total) * 100) : 0;
                    ?>
                        <div class="course-item">
                            <h3><?= htmlspecialchars($curso['curso_nome']) ?></h3>
                            <p>Progresso: <?= $porcentagem ?>%</p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você ainda não iniciou nenhum curso.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Botões -->
        <div class="action-buttons">
            <a href="areadoaluno.php">Ir para Área do Aluno</a>
            <form action="../funcoes/sessoes/logout.php" method="post">
                <button type="submit" class="btn-sair">Sair da Conta</button>
            </form>
        </div>

        <!-- Painel lateral -->
        <div id="personalDataPanel" class="personal-data-panel">
            <span class="close-btn" onclick="togglePersonalData()">✖️</span>
            <h3>Dados Pessoais</h3>
            <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?></p>
            <p><strong>Usuário:</strong> <?= htmlspecialchars($usuario) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= htmlspecialchars($data_nascimento) ?></p>

            <hr>

            <h4>Editar Dados</h4>
            <form action="funcoes/atualizar_dados.php" method="post" class="edit-form">
                <label for="novo_nome">Novo nome:</label>
                <input type="text" name="novo_nome" id="novo_nome" placeholder="Seu nome completo">

                <label for="novo_usuario">Novo nome de usuário:</label>
                <input type="text" name="novo_usuario" id="novo_usuario" placeholder="Novo nome de usuário">

                <label for="novo_email">Novo e-mail:</label>
                <input type="email" name="novo_email" id="novo_email" placeholder="Novo e-mail">

                <label for="nova_senha">Nova senha:</label>
                <input type="password" name="nova_senha" id="nova_senha" placeholder="Nova senha">

                <label for="confirmar_senha">Confirmar nova senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirmar senha">

                <input type="submit" value="Salvar Alterações" class="upload-btn">
            </form>
        </div>


        <script>
            function openTab(evt, tabName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                    tabcontent[i].classList.remove("active");
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].classList.remove("active");
                }
                document.getElementById(tabName).style.display = "block";
                document.getElementById(tabName).classList.add("active");
                evt.currentTarget.classList.add("active");
            }


            // Inicializa aba ativa
            document.addEventListener("DOMContentLoaded", () => {
                document.querySelector(".tabcontent.active").style.display = "block";
            });

            // Preview da imagem
            document.getElementById('upload').addEventListener('change', function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('userPhoto').src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            });

            function togglePersonalData() {
                document.getElementById("personalDataPanel").classList.toggle("open");
            }
        </script>
</body>

</html>