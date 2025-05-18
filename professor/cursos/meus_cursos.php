<?php
session_start();
require_once '../../funcoes/conexao.php';

// Verifica se está logado
if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
  die("Acesso negado. Faça login.");
}

$id_usuario = $_SESSION['id'];
$tipo_usuario = $_SESSION['tipo'];

// Buscar cursos criados por esse usuário
$sql = "SELECT * FROM cursos WHERE criado_por_id = ? AND tipo_criador = ? ORDER BY data_criacao DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("is", $id_usuario, $tipo_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Meus Cursos - CW Cursos</title>
  <link rel="shortcut icon" href="../../images/logotipocw.png" />
  <link rel="stylesheet" href="partials/style.css">
  <link rel="stylesheet" href="css/cursos.css">
</head>

<body>

  <?php include 'partials/header.php'; ?>

  <div class="container">
    <?php if (isset($_SESSION['mensagem'])): ?>
      <div class="alerta <?php echo $_SESSION['mensagem_tipo']; ?>">
        <?php echo $_SESSION['mensagem']; ?>
      </div>
      <?php unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); ?>
    <?php endif; ?>

    <div class="welcome-text">
      <h1>Meus Cursos</h1>
      <p>Gerencie os cursos que você criou 📚</p>
    </div>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Buscar curso por nome...">
    </div>

    <section class="list-section">
      <?php if ($resultado->num_rows > 0): ?>
        <?php while ($curso = $resultado->fetch_assoc()): ?>
          <div class="course-card">
            <img src="../../<?php echo htmlspecialchars($curso['imagem']); ?>" alt="Imagem atual" style="max-width:100%; border-radius: 8px;">
            <h3><?php echo htmlspecialchars($curso['nome']); ?></h3>
            <p>Categoria: <?php echo htmlspecialchars($curso['categoria']); ?></p>
            <p>Dificuldade: <?php echo ucfirst($curso['dificuldade']); ?></p>
            <p style="font-size: 0.9em; color: gray;">Criado em: <?php echo date('d/m/Y H:i', strtotime($curso['data_criacao'])); ?></p>
            <div style="display: flex; gap: 10px;">
              <a href="ver_conteudo_curso.php?id=<?php echo $curso['id']; ?>" class="btn-publicar" style="background-color: #3498db;">Ver Conteúdo</a>
              <a href="editar_curso.php?id=<?php echo $curso['id']; ?>" class="btn-publicar">Editar</a>
              <a href="javascript:void(0);" onclick="confirmarExclusao(<?php echo $curso['id']; ?>)" class="btn-excluir" style="background-color: #e74c3c;">Excluir</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Você ainda não criou nenhum curso.</p>
      <?php endif; ?>
    </section>
  </div>

  <?php include 'partials/footer.php'; ?>
  <script>
    function confirmarExclusao(id) {
      if (confirm("Tem certeza que deseja excluir este curso? Esta ação não pode ser desfeita.")) {
        window.location.href = 'funcoes/excluir_curso.php?id=' + id;
      }
    }
  </script>
  <script>
    // Remove automaticamente alertas após 4 segundos
    setTimeout(function() {
      const alerta = document.querySelector('.alerta');
      if (alerta) {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = 0;
        setTimeout(() => alerta.remove(), 500); // remove do DOM depois de desaparecer
      }
    }, 4000);
  </script>
  <script>
    document.getElementById('searchInput').addEventListener('input', function() {
      const filtro = this.value.toLowerCase();
      const cards = document.querySelectorAll('.course-card');

      cards.forEach(card => {
        const titulo = card.querySelector('h3').textContent.toLowerCase();
        card.style.display = titulo.includes(filtro) ? 'block' : 'none';
      });
    });
  </script>

</body>

</html>