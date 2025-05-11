<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: http://localhost/AAP-CW_Cursos/cadastro_login/aluno/signin.php');
    exit;
}

include_once('../../funcoes/conexao.php'); // Caminho da sua conexão, ajuste se necessário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $aluno_id = $_SESSION['id'];
    $plano = $_POST['plano'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $forma_pagamento = $_POST['forma_pagamento'] ?? '';

    // Validação simples
    if ($plano && $nome && $email && $celular && $cpf && $forma_pagamento) {
        // Prepara o insert (ajuste o nome da tabela e colunas conforme o seu banco)
        $query = "INSERT INTO pagamentos (aluno_id, plano, nome, email, celular, cpf, forma_pagamento, data_pagamento) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conexao->prepare($query);
        $stmt->bind_param("issssss", $aluno_id, $plano, $nome, $email, $celular, $cpf, $forma_pagamento);

        if ($stmt->execute()) {
            // Redireciona ou exibe mensagem de sucesso
            header('Location: sucesso_assinatura.php'); // Crie essa página se quiser
            exit;
        } else {
            $erro = "Erro ao processar pagamento. Tente novamente.";
        }

        $stmt->close();
    } else {
        $erro = "Todos os campos são obrigatórios.";
    }

    $conexao->close();
} else {
    $erro = "Acesso inválido.";
}

// Em caso de erro:
if (isset($erro)) {
    echo "<p style='color:red; text-align:center;'>$erro</p>";
    echo "<p style='text-align:center;'><a href='assinar_plano.php'>Voltar</a></p>";
}
?>
