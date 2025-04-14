<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db_connection.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $linkedin = $_POST['linkedin'];
    $experiencia = $_POST['experiencia'];
    $area_conhecimento = $_POST['area_conhecimento'];
    $disponibilidade = $_POST['disponibilidade'];

    // Tratamento do upload do currículo
    $curriculo_dir = "uploads/curriculos/"; // Diretório onde o currículo será salvo
    $curriculo_path = $curriculo_dir . basename($_FILES["curriculo"]["name"]);
    $curriculo_tipo = strtolower(pathinfo($curriculo_path, PATHINFO_EXTENSION));

    // Valida se o arquivo é um PDF
    if($curriculo_tipo != "pdf") {
        die("Erro: Apenas arquivos PDF são permitidos para o currículo.");
    }

    // Verifica se o diretório existe, se não, cria o diretório
    if (!is_dir($curriculo_dir)) {
        mkdir($curriculo_dir, 0777, true);
    }

    // Tenta mover o arquivo para o servidor
    if (move_uploaded_file($_FILES["curriculo"]["tmp_name"], $curriculo_path)) {
        // Prepara a query SQL para inserir os dados
        $sql = "INSERT INTO professores_voluntarios (nome, cpf, rg, data_nascimento, endereco, email, telefone, linkedin, experiencia, area_conhecimento, disponibilidade, curriculo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Associa os parâmetros à instrução preparada
            $stmt->bind_param("ssssssssssss", $nome, $cpf, $rg, $data_nascimento, $endereco, $email, $telefone, $linkedin, $experiencia, $area_conhecimento, $disponibilidade, $curriculo_path);
            
            if ($stmt->execute()) {
                // Se a inscrição for bem-sucedida, exibe um alert e redireciona para o formulário
                echo "<script>alert('Inscrição realizada com sucesso!'); window.location.href='forms.html';</script>";
            } else {
                echo "<script>alert('Ocorreu um erro ao enviar a inscrição. Tente novamente.'); window.location.href='forms.html';</script>";
            }

            // Fecha a instrução
            $stmt->close();
        } else {
            echo "Erro no banco de dados: Não foi possível preparar a consulta.";
        }
    } else {
        echo "Erro: Falha ao enviar o currículo. Por favor, tente novamente.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "Erro: Requisição inválida.";
}
?>
