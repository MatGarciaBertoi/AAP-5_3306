<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_GET['id'])) {
  die("ID do curso não especificado.");
}

$id_curso = (int) $_GET['id'];

// Verifica se o curso é do usuário logado
if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
  die("Acesso negado.");
}

$id_usuario = $_SESSION['id'];
$tipo_usuario = $_SESSION['tipo'];

// Buscar curso
$sql = "SELECT * FROM cursos WHERE id = ? AND criado_por_id = ? AND tipo_criador = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iis", $id_curso, $id_usuario, $tipo_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Curso não encontrado ou acesso negado.");
}

$curso = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Editar Curso - CW Cursos</title>
  <link rel="shortcut icon" href="../../images/logotipocw.png" />
  <link rel="stylesheet" href="partials/style.css">
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <?php include 'partials/header.php'; ?>

  <div class="container">
    <div class="welcome-text">
      <h1>Editar Curso</h1>
      <p>Atualize as informações do curso ✏️</p>
    </div>

    <form class="course-form" action="funcoes/atualizar_curso.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $curso['id']; ?>">
      <input type="hidden" name="imagem_atual" value="<?php echo $curso['imagem']; ?>">

      <div class="form-group">
        <label for="nome-curso">Nome do Curso</label>
        <input type="text" id="nome-curso" name="nome-curso" value="<?php echo htmlspecialchars($curso['nome']); ?>" required>
      </div>

      <div class="form-group">
        <label for="categoria">Categoria</label>
        <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($curso['categoria']); ?>" required>
      </div>

      <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="5" required><?php echo htmlspecialchars($curso['descricao']); ?></textarea>
      </div>

      <div class="form-group">
        <label>Imagem Atual</label><br>
        <img src="funcoes/uploads/<?php echo htmlspecialchars($curso['imagem']); ?>" alt="Imagem atual" style="max-width: 200px; border-radius: 8px;"><br><br>

        <label for="imagem">Alterar Imagem de Capa (opcional)</label>
        <input type="file" id="imagem" name="imagem" accept="image/*">
      </div>

      <div class="form-group">
        <label for="dificuldade">Dificuldade</label>
        <select id="dificuldade" name="dificuldade" required>
          <option value="iniciante" <?php if ($curso['dificuldade'] == 'iniciante') echo 'selected'; ?>>Iniciante</option>
          <option value="intermediario" <?php if ($curso['dificuldade'] == 'intermediario') echo 'selected'; ?>>Intermediário</option>
          <option value="avancado" <?php if ($curso['dificuldade'] == 'avancado') echo 'selected'; ?>>Avançado</option>
        </select>
      </div>

      <div class="form-group">
        <button type="submit" class="btn-publicar">Salvar Alterações</button>
        <a href="list_courses.php">Cancelar</a>
      </div>
    </form>
  </div>

  <?php include 'partials/footer.php'; ?>
</body>

</html>
