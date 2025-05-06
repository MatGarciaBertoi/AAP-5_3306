<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adicionar Aula - CW Cursos</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/adicionar_aula.css">
</head>

<body>

    <?php include 'partials/header.php'; ?>
    <div class="container">
        <div class="welcome-text">
            <h1>Adicionar Aula</h1>
            <p>Preencha as informações para adicionar uma nova aula 📚</p>

            <?php if (isset($_SESSION['mensagem'])): ?>
                <p class="mensagem <?= $_SESSION['mensagem_tipo'] ?>">
                    <?= $_SESSION['mensagem'] ?>
                </p>
                <?php unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); ?>
            <?php endif; ?>
        </div>

        <section class="form-section">
            <form class="course-form" method="POST" action="funcoes/processa_aula.php">
                <div class="form-group">
                    <label for="curso">Curso</label>
                    <select id="curso" name="curso" required>
                        <option value="">Selecione o curso</option>
                        <?php
                        require_once '../../funcoes/conexao.php';
                        $stmt = $conexao->prepare("SELECT id, nome FROM cursos WHERE criado_por_id = ? AND tipo_criador = ?");
                        $stmt->bind_param("is", $_SESSION['id'], $_SESSION['tipo']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($curso = $result->fetch_assoc()) {
                            echo "<option value=\"{$curso['nome']}\">{$curso['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="titulo">Título da Aula</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: Introdução ao Curso" required>
                </div>

                <div class="form-group">
                    <label for="conteudo-aula">Conteúdo da Aula</label>
                    <textarea id="conteudo-aula" name="conteudo-aula" rows="5" placeholder="Detalhes do conteúdo da aula..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="video">Link do Vídeo</label>
                    <input type="url" id="video" name="video" placeholder="URL do vídeo (YouTube, Vimeo...)" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-publicar">Adicionar Aula</button>
                </div>
            </form>
        </section>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
