<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel do Professor - CW Cursos</title>
  <link rel="shortcut icon" href="../images/logotipocw.png" />
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="partials/style.css">
</head>

<body>
  <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
  <div class="container">
    <div class="welcome-text">
      <h1>Bem-vindo, Professor!</h1>
      <p>Continue impactando alunos com seus cursos incríveis 🚀</p>
    </div>
    <section class="dashboard">
      <div class="card">
        <h2>5</h2>
        <p>Cursos Criados</p>
      </div>
      <div class="card">
        <h2>25</h2>
        <p>Aulas Publicadas</p>
      </div>
      <div class="card">
        <h2>150</h2>
        <p>Alunos Matriculados</p>
      </div>
      <div class="card">
        <h2>3</h2>
        <p>Mensagens Novas</p>
      </div>
    </section>

    <section class="notifications">
      <h3>Notificações</h3>
      <p>🚧 Manutenção agendada para 01/05 às 02:00 AM.</p>
      <p>📢 Nova ferramenta de agendamento de aulas disponível!</p>
    </section>

  </div>
  <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>