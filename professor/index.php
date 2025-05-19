<?php
include_once('../funcoes/sessoes/check_professor.php');
require_once '../funcoes/conexao.php';

$professor_id = $_SESSION['id'];

// Cursos criados pelo professor
$sqlCursos = "SELECT COUNT(*) AS total_cursos FROM cursos WHERE criado_por_id = ? AND tipo_criador = 'professor'";
$stmtCursos = $conexao->prepare($sqlCursos);
$stmtCursos->bind_param("i", $professor_id);
$stmtCursos->execute();
$resultCursos = $stmtCursos->get_result()->fetch_assoc();
$total_cursos = $resultCursos['total_cursos'] ?? 0;

// Aulas publicadas nos cursos do professor
$sqlAulas = "
  SELECT COUNT(a.id) AS total_aulas
  FROM aulas a
  JOIN cursos c ON a.curso_id = c.id
  WHERE c.criado_por_id = ? AND c.tipo_criador = 'professor'";
$stmtAulas = $conexao->prepare($sqlAulas);
$stmtAulas->bind_param("i", $professor_id);
$stmtAulas->execute();
$resultAulas = $stmtAulas->get_result()->fetch_assoc();
$total_aulas = $resultAulas['total_aulas'] ?? 0;

// Alunos matriculados nos cursos do professor
$sqlAlunos = "
  SELECT COUNT(DISTINCT i.aluno_id) AS total_alunos
  FROM inscricoes i
  JOIN cursos c ON i.curso_id = c.id
  WHERE c.criado_por_id = ? AND c.tipo_criador = 'professor'";
$stmtAlunos = $conexao->prepare($sqlAlunos);
$stmtAlunos->bind_param("i", $professor_id);
$stmtAlunos->execute();
$resultAlunos = $stmtAlunos->get_result()->fetch_assoc();
$total_alunos = $resultAlunos['total_alunos'] ?? 0;
?>

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
        <h2><?= $total_cursos ?></h2>
        <p>Cursos Criados</p>
      </div>
      <div class="card">
        <h2><?= $total_aulas ?></h2>
        <p>Aulas Publicadas</p>
      </div>
      <div class="card">
        <h2><?= $total_alunos ?></h2>
        <p>Alunos Matriculados</p>
      </div>
    </section>


  </div>
  <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>