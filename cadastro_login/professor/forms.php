<?php
include '../../funcoes/conexao.php';

// Função para limpar e proteger os dados recebidos
function limpar($dado)
{
    return htmlspecialchars(trim($dado));
}

// Função para validar o CPF
function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($c = 0; $c < $t; $c++) {
            $soma += $cpf[$c] * (($t + 1) - $c);
        }
        $digito = ((10 * $soma) % 11) % 10;
        if ($cpf[$c] != $digito) {
            return false;
        }
    }
    return true;
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpeza dos dados
    $nome = limpar($_POST['nome']);
    $cpf = limpar($_POST['cpf']);
    $rg = limpar($_POST['rg']);
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = limpar($_POST['endereco']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telefone = limpar($_POST['telefone']);
    $linkedin = filter_var($_POST['linkedin'], FILTER_SANITIZE_URL);
    $experiencia = limpar($_POST['experiencia']);
    $area_conhecimento = limpar($_POST['area_conhecimento']);
    $disponibilidade = limpar($_POST['disponibilidade']);

    // Validação de CPF
    if (!validarCPF($cpf)) {
        die("CPF inválido.");
    }

    // Verificação de CPF duplicado
    $verificar = $conexao->prepare("SELECT id FROM professores_voluntarios WHERE cpf = ?");
    $verificar->bind_param("s", $cpf);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        die("CPF já cadastrado.");
    }
    $verificar->close();

    // Caminho absoluto no servidor (para salvar o arquivo fisicamente)
    $caminho_fisico = $_SERVER['DOCUMENT_ROOT'] . "/AAP-CW_Cursos/adm/usuarios/professor/uploads/curriculos/";
    $curriculo_tipo = strtolower(pathinfo($_FILES["curriculo"]["name"], PATHINFO_EXTENSION));

    if ($_FILES["curriculo"]["error"] !== UPLOAD_ERR_OK) {
        die("Erro no upload do arquivo. Código: " . $_FILES["curriculo"]["error"]);
    }

    if ($curriculo_tipo != "pdf") {
        die("Apenas arquivos PDF são permitidos.");
    }

    $nome_arquivo = uniqid("curriculo_", true) . ".pdf";

    // Caminho para o navegador (este será salvo no banco e usado no link)
    $curriculo_path = "/AAP-CW_Cursos/adm/usuarios/professor/uploads/curriculos/" . $nome_arquivo;

    if (!move_uploaded_file($_FILES["curriculo"]["tmp_name"], $caminho_fisico . $nome_arquivo)) {
        die("Erro ao salvar o currículo.");
    }


    // Inserção no banco
    $sql = "INSERT INTO professores_voluntarios (nome, cpf, rg, data_nascimento, endereco, email, telefone, linkedin, experiencia, area_conhecimento, disponibilidade, curriculo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }

    $stmt->bind_param("ssssssssssss", $nome, $cpf, $rg, $data_nascimento, $endereco, $email, $telefone, $linkedin, $experiencia, $area_conhecimento, $disponibilidade, $curriculo_path);

    if ($stmt->execute()) {
        echo "<script>alert('Formulário enviado com sucesso!'); window.location.href='http://localhost/AAP-CW_Cursos/TelaInicial/index.php';</script>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
    exit;
}
?>


<!-- HTML do formulário -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inscrição - Professor Voluntário</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="forms.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <div class="container">
        <div class="container-main">
            <div class="card-image">
                <img src="../../images/homem-mulher-discutindo.png" alt="Mulher de oculos sorrindo">
            </div>
            <div class="container-card">
                <div class="card">
                    <h1>Seu próximo grande passo como professor da CW começa aqui</h1>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Seção de Dados Pessoais -->
                        <h3>Dados Pessoais</h3>

                        <div class="label-float">
                            <input type="text" id="nome" name="nome" required>
                            <label for="nome">Nome Completo</label>
                        </div>

                        <div class="label-float">
                            <input type="text" id="cpf" name="cpf" maxlength="11" pattern="\d{11}" inputmode="numeric" title="Digite apenas números (11 dígitos)" required>
                            <label for="cpf">CPF</label>
                        </div>

                        <div class="label-float">
                            <input type="text" id="rg" name="rg" maxlength="9" pattern="\d{7,9}" inputmode="numeric" title="Digite entre 7 e 9 dígitos numéricos" required>
                            <label for="rg">RG</label>
                        </div>

                        <div class="label-float">
                            <input type="date" id="data_nascimento" name="data_nascimento" required>
                            <label for="data_nascimento">Data de Nascimento</label>
                        </div>

                        <div class="label-float">
                            <input type="text" id="endereco" name="endereco" required>
                            <label for="endereco">Endereço Completo</label>
                        </div>

                        <div class="label-float">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="label-float">
                            <input type="tel" id="telefone" name="telefone" maxlength="11" pattern="\d{10,11}" inputmode="numeric" title="Digite DDD + número (10 ou 11 dígitos)" required>
                            <label for="telefone">Telefone</label>
                        </div>

                        <div class="label-float">
                            <input type="url" id="linkedin" name="linkedin" required>
                            <label for="linkedin">LinkedIn</label>
                        </div>

                        <!-- Seção de Perguntas -->
                        <h3>Perguntas</h3>

                        <div class="label-float">
                            <textarea id="experiencia" name="experiencia" rows="4" required></textarea>
                            <label for="experiencia">Qual sua experiência com Marketing Digital?</label>
                        </div>

                        <div class="label-float">
                            <input type="text" id="area_conhecimento" name="area_conhecimento" required>
                            <label for="area_conhecimento">Áreas de Conhecimento em Marketing</label>
                        </div>

                        <div class="label-float">
                            <input type="text" id="disponibilidade" name="disponibilidade" required>
                            <label for="disponibilidade">Disponibilidade de Horas por Semana para Produção de Conteúdo</label>
                        </div>

                        <!-- Envio de Currículo -->
                        <h3>Envio de Currículo</h3>

                        <div class="custom-file">
                            <span for="curriculo">Currículo (em PDF)</span>
                            <input type="file" id="curriculo" name="curriculo" accept=".pdf" required>
                        </div>


                        <div class="dados">
                            <!-- Termos de Uso LGPD -->
                            <p class="lgpd">
                                Seus dados serão tratados de acordo com a <strong>Lei Geral de Proteção de Dados Pessoais (LGPD)</strong>.
                                Ao enviar este formulário, você concorda com o uso das informações para fins de avaliação e contato.
                            </p>
                        </div>

                        <!-- Botão de submit centralizado -->
                        <div class="justify-center">
                            <button type="submit">Enviar Inscrição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <!-- Script para bloquear letras e permitir apenas números -->
    <script>
        function somenteNumeros(event) {
            const tecla = event.key;
            // Permite apenas dígitos (0-9), backspace, delete, setas e tab
            if (!/[\d]/.test(tecla) &&
                tecla !== "Backspace" &&
                tecla !== "Delete" &&
                tecla !== "ArrowLeft" &&
                tecla !== "ArrowRight" &&
                tecla !== "Tab") {
                event.preventDefault();
            }
        }

        document.getElementById("cpf").addEventListener("keydown", somenteNumeros);
        document.getElementById("rg").addEventListener("keydown", somenteNumeros);
        document.getElementById("telefone").addEventListener("keydown", somenteNumeros);
    </script>
</body>

</html>