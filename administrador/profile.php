<?php
include_once('../funcoes/sessoes/check_administrador.php');
include_once('../funcoes/conexao.php');
include_once('../funcoes/config.php');

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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - Cursos</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>

    <?php include '../funcoes/usuario/acessibilidade.php'; ?>

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
            <p>Bem-vindo ao seu perfil, aqui verá seu dados em nossa plataforma!</p>
        </div>

        <!-- Botões -->
        <div class="action-buttons">
            <a href="index.php">Ir para Área do Professor</a>
            <a href="../TelaInicial/index.php">Ir para Menu Inicial</a>
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

        <!-- Chatra {literal} -->
        <script src="../funcoes/chatbot/suporte/chatra.js"> </script>
</body>

</html>