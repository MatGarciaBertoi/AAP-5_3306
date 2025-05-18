<?php
session_start();
require_once '../../../funcoes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int) $_POST['id'];
  $nome = trim($_POST['nome-curso']);
  $categoria = trim($_POST['categoria']);
  $descricao = trim($_POST['descricao']);
  $dificuldade = $_POST['dificuldade'];
  $imagem_atual = $_POST['imagem_atual'];

  // Verifica se o curso é do usuário
  if ($_SESSION['tipo'] === 'administrador') {
    // Administrador pode editar qualquer curso
    $stmt = $conexao->prepare("SELECT * FROM cursos WHERE id = ?");
    $stmt->bind_param("i", $id);
  } else {
    // Outros só podem editar os próprios cursos
    $stmt = $conexao->prepare("SELECT * FROM cursos WHERE id = ? AND criado_por_id = ? AND tipo_criador = ?");
    $stmt->bind_param("iis", $id, $_SESSION['id'], $_SESSION['tipo']);
  }

  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows === 0) {
    $_SESSION['mensagem'] = 'Acesso negado ou curso não encontrado.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: ../list_courses.php');
    exit;
  }

  // Upload de imagem (se enviado)
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid() . '.' . $ext;
    $caminho_absoluto = '../../../funcoes/uploads/cursos/' . $novoNome;
    $caminho_relativo = 'funcoes/uploads/cursos/' . $novoNome;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_absoluto)) {
      $imagem_final = $caminho_relativo;

      // Exclui imagem antiga (se existir)
      $caminho_antigo_absoluto = '../../../' . $imagem_atual;
      if (!empty($imagem_atual) && file_exists($caminho_antigo_absoluto)) {
        unlink($caminho_antigo_absoluto);
      }
    } else {
      $imagem_final = $imagem_atual;
    }
  } else {
    $imagem_final = $imagem_atual;
  }

  $sql = "UPDATE cursos SET nome = ?, categoria = ?, descricao = ?, imagem = ?, dificuldade = ? WHERE id = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("sssssi", $nome, $categoria, $descricao, $imagem_final, $dificuldade, $id);
  $stmt->execute();

  $_SESSION['mensagem'] = 'Curso atualizado com sucesso!';
  $_SESSION['mensagem_tipo'] = 'sucesso';
  header('Location: ../list_courses.php');
  exit;
}
