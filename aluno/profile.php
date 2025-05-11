<?php
session_start();
include_once('../funcoes/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: http://localhost/AAP-CW_Cursos/cadastro_login/aluno/signin.php');
    exit();
}

$usuario = $_SESSION['usuario'];

// Consulta SQL para obter a foto de perfil e outros dados
$sql = "SELECT photo, email, data_nascimento FROM usuarios WHERE usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$profile_photo = $row ? $row['photo'] : '../images/default_profile.jpg';
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
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>

    <div class="profile-container">
        <!-- Ícone de engrenagem -->
        <div class="settings-icon" onclick="togglePersonalData()">⚙️</div>

        <!-- Foto do perfil -->
        <div class="profile-photo">
            <img src="<?php echo $profile_photo; ?>" alt="Foto do Usuário" id="userPhoto">
        </div>

        <!-- Formulário para upload de foto -->
        <div class="upload-section">
            <form action="../funcoes/usuario/upload_photo.php" method="post" enctype="multipart/form-data">
                <input type="file" name="photo" id="upload" accept="image/*">
                <label for="upload" class="upload-label">Carregar nova foto</label>
                <input type="submit" value="Atualizar Foto" class="upload-btn">
            </form>
        </div>

        <!-- Informações do usuário -->
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($usuario); ?></h1>
            <p>Bem-vindo ao seu perfil, aqui verá seu progresso em nossa plataforma!</p>
        </div>

        <!-- Abas para navegação -->
        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'CursosConcluidos')">Cursos Concluídos</button>
            <button class="tablinks" onclick="openTab(event, 'ProgressoAtual')">Progresso Atual</button>
            <button class="tablinks" onclick="openTab(event, 'Habilidades')">Habilidades</button>
        </div>

        <!-- Conteúdo da aba "Cursos Concluídos" -->
        <div id="CursosConcluidos" class="tabcontent active">
            <div class="course-list">
                <div class="course-item">
                    <h3>SEO para Iniciantes</h3>
                    <p>Concluído em: 25/04/2025</p>
                </div>
            </div>
        </div>

        <!-- Conteúdo da aba "Progresso Atual" -->
        <div id="ProgressoAtual" class="tabcontent">
            <div class="course-list">
                <div class="course-item">
                    <h3>Introdução ao Marketing Digital</h3>
                    <p>Progresso: 75%</p>
                </div>
                <div class="course-item">
                    <h3> Modelos de Negócios Digitais e Monetização Online</h3>
                    <p>Progresso: 0%</p>
                </div>
            </div>
        </div>

        <!-- Conteúdo da aba "Habilidades" -->
        <div id="Habilidades" class="tabcontent">
            <div class="course-list">
                <div class="course-item">
                    <h3>Introdução ao Marketing Digital</h3>
                    <p>Habilidade adquirida: 65%</p>
                </div>
                <div class="course-item">
                    <h3>Modelos de Negócios Digitais e Monetização Online</h3>
                    <p>Habilidade adquirida: 0%</p>
                </div>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="action-buttons">
            <a href="areadoaluno.php">Voltar para Área do Aluno</a>
            <form action="../funcoes/sessoes/logout.php" method="post">
                <button type="submit" class="btn-sair">Sair</button>
            </form>
        </div>

        <!-- Painel lateral expansível para dados pessoais -->
        <div id="personalDataPanel" class="personal-data-panel">
            <span class="close-btn" onclick="togglePersonalData()">✖️</span>
            <h3>Dados Pessoais</h3>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo $data_nascimento; ?> </p>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;

            // Oculta todos os conteúdos das abas
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }

            // Remove a classe "active" de todos os botões
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }

            // Exibe a aba clicada e adiciona a classe "active"
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }

        // Inicializa a primeira aba como visível
        document.getElementById("CursosConcluidos").style.display = "block";

        // Pré-visualização da foto antes do upload
        const uploadInput = document.getElementById('upload');
        const userPhoto = document.getElementById('userPhoto');

        uploadInput.addEventListener('change', function() {
            const reader = new FileReader();
            reader.onload = function(e) {
                userPhoto.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        });

        function togglePersonalData() {
            var panel = document.getElementById("personalDataPanel");
            panel.classList.toggle("open");
        }
    </script>
</body>

</html>