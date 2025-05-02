<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Criar Novo Curso - CW Cursos</title>
  <link rel="shortcut icon" href="../../images/logotipocw.png" />
  <link rel="stylesheet" href="partials/style.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/cursos.css">
</head>

<body>

  <?php include 'partials/header.php'; ?> <!-- Inclui o header -->

  <div class="container">
    <?php
    if (isset($_SESSION['mensagem'])) :
      $classe = $_SESSION['mensagem_tipo'] === 'erro' ? 'alerta-erro' : 'alerta-sucesso';
    ?>
      <div class="<?php echo $classe; ?>">
        <?php echo $_SESSION['mensagem']; ?>
      </div>
    <?php
      unset($_SESSION['mensagem']);
      unset($_SESSION['mensagem_tipo']);
    endif;
    ?>
    <div class="welcome-text">
      <h1>Criar Novo Curso</h1>
      <p>Preencha as informações para publicar seu curso 🚀</p>
    </div>
    <section class="form-section">
      <form class="course-form" id="course-form" action="funcoes/salvar_curso.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nome-curso">Nome do Curso</label>
          <input type="text" id="nome-curso" name="nome-curso" placeholder="Ex: Programação para Iniciantes" required>
        </div>

        <div class="form-group">
          <label for="categoria">Categoria</label>
          <input type="text" id="categoria" name="categoria" placeholder="Ex: Tecnologia, Design, Negócios" required>
        </div>

        <div class="form-group">
          <label for="descricao">Descrição</label>
          <textarea id="descricao" name="descricao" rows="5" placeholder="Descreva o que o aluno aprenderá..." required></textarea>
        </div>

        <div class="form-group">
          <label for="imagem">Imagem de Capa</label>
          <input type="file" id="imagem" name="imagem" accept="image/*" required>
          <div id="preview-container">
            <img id="preview-imagem" src="#" alt="Pré-visualização" style="display: none; max-width: 100%; margin-top: 10px; border-radius: 8px;" />
          </div>
        </div>


        <div class="form-group">
          <label for="dificuldade">Dificuldade</label>
          <select id="dificuldade" name="dificuldade" required>
            <option value="">Selecione</option>
            <option value="iniciante">Iniciante</option>
            <option value="intermediario">Intermediário</option>
            <option value="avancado">Avançado</option>
          </select>
        </div>

        <div class="form-group">
          <button type="submit" class="btn-publicar">Publicar Curso</button>
        </div>
      </form>
    </section>
  </div>

  <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->

  <script>
    // Espera a página carregar
    document.addEventListener('DOMContentLoaded', function() {
      const alerta = document.querySelector('.alerta-erro, .alerta-sucesso');

      if (alerta) {
        setTimeout(() => {
          alerta.style.transition = 'opacity 0.5s ease';
          alerta.style.opacity = 0;

          setTimeout(() => {
            alerta.remove();
          }, 500); // remove após o fade-out
        }, 4000); // some depois de 4 segundos
      }
    });
  </script>

<script>
  const inputImagem = document.getElementById('imagem');
  const preview = document.getElementById('preview-imagem');

  inputImagem.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }

      reader.readAsDataURL(file);
    } else {
      preview.src = "#";
      preview.style.display = 'none';
    }
  });
</script>

</body>

</html>