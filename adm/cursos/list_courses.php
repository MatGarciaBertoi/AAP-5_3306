<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'administrador') {
    die("Acesso negado. Somente administradores podem acessar essa página.");
}

// Termo de busca
$termoBusca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$termoBuscaSQL = "%" . $conexao->real_escape_string($termoBusca) . "%";

// Consulta: cursos do ADMINISTRADOR
$sql_admin = "SELECT * FROM cursos WHERE tipo_criador = 'administrador'";
if (!empty($termoBusca)) {
    $sql_admin .= " AND nome LIKE '$termoBuscaSQL'";
}
$sql_admin .= " ORDER BY data_criacao DESC";
$result_admin = $conexao->query($sql_admin);

// Consulta: cursos dos DEMAIS
$sql_outros = "SELECT * FROM cursos WHERE tipo_criador != 'administrador'";
if (!empty($termoBusca)) {
    $sql_outros .= " AND nome LIKE '$termoBuscaSQL'";
}
$sql_outros .= " ORDER BY data_criacao DESC";
$result_outros = $conexao->query($sql_outros);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Cursos - Painel Admin</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/list.css">
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <div class="container course-list">
        <h1>Todos os Cursos da Plataforma</h1>

        <!-- Barra de Pesquisa -->
        <form method="GET" action="" style="margin-bottom: 20px;">
            <input type="text" name="busca" placeholder="Buscar por nome do curso" value="<?php echo htmlspecialchars($termoBusca); ?>" style="padding: 8px; width: 300px;">
            <button type="submit" style="padding: 8px 16px;">Buscar</button>
        </form>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alerta-sucesso">Curso excluído com sucesso.</div>
        <?php elseif (isset($_GET['erro'])): ?>
            <div class="alerta-erro">Erro ao excluir o curso.</div>
        <?php endif; ?>

        <h2>Cursos Criados pela CW</h2>
        <?php if ($result_admin->num_rows > 0): ?>
            <?php while ($curso = $result_admin->fetch_assoc()): ?>
                <div class="course-card">
                    <h3><?php echo htmlspecialchars($curso['nome']); ?></h3>
                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($curso['categoria']); ?></p>
                    <p><strong>Dificuldade:</strong> <?php echo ucfirst($curso['dificuldade']); ?></p>
                    <p><strong>Criado em:</strong> <?php echo date('d/m/Y H:i', strtotime($curso['data_criacao'])); ?></p>
                    <div class="course-actions">
                        <a href="editar_curso.php?id=<?php echo $curso['id']; ?>" class="btn-edit">Editar</a>
                        <a href="funcoes/excluir_curso.php?id=<?php echo $curso['id']; ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este curso?');">Excluir</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum curso encontrado.</p>
        <?php endif; ?>

        <h2>Cursos Criados pelos Professores</h2>
        <?php if ($result_outros->num_rows > 0): ?>
            <?php while ($curso = $result_outros->fetch_assoc()): ?>
                <div class="course-card">
                    <h3><?php echo htmlspecialchars($curso['nome']); ?></h3>
                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($curso['categoria']); ?></p>
                    <p><strong>Dificuldade:</strong> <?php echo ucfirst($curso['dificuldade']); ?></p>
                    <p><strong>Criado por:</strong> <?php echo ucfirst($curso['tipo_criador']); ?> (ID: <?php echo $curso['criado_por_id']; ?>)</p>
                    <p><strong>Criado em:</strong> <?php echo date('d/m/Y H:i', strtotime($curso['data_criacao'])); ?></p>
                    <div class="course-actions">
                        <a href="editar_curso.php?id=<?php echo $curso['id']; ?>" class="btn-edit">Editar</a>
                        <a href="funcoes/excluir_curso.php?php echo $curso['id']; ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este curso?');">Excluir</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum curso encontrado.</p>
        <?php endif; ?>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script>
        setTimeout(() => {
            const alertaSucesso = document.querySelector('.alerta-sucesso');
            const alertaErro = document.querySelector('.alerta-erro');

            if (alertaSucesso) alertaSucesso.classList.add('hidden');
            if (alertaErro) alertaErro.classList.add('hidden');
        }, 3000);
    </script>

</body>

</html>