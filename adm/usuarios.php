<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/usuarios.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">

        <main>
            <section id="usuarios" class="section">
                <h2>Gerenciar Usuários</h2>

                <h3>Alunos</h3>
                <button onclick="window.location.href='usuarios/aluno/cadastro.php?type=aluno'">Adicionar</button>
                <button onclick="window.location.href='usuarios/aluno/list.php?type=aluno'">Listar Cadastrados</button>

                <h3>Professores</h3>
                <button onclick="window.location.href='usuarios/professor/add.php?type=professor&status=pendente'">Visualizar e Adicionar</button>
                <button onclick="window.location.href='usuarios/professor/list.php?type=professor'">Listar Cadastrados</button>

                <h3>Administradores</h3>
                <button onclick="window.location.href='usuarios/administrador/cadastro.php?type=administrador'">Adicionar</button>
                <button onclick="window.location.href='usuarios/administrador/list.php?type=administrador'">Listar Cadastrados</button>
            </section>
        </main>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>