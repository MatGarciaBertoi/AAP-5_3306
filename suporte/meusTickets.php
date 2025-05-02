<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Suporte</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/meusTickets.css">
    <!--BOOTSTRAPS inicio-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--BOOTSRAPS FIM-->
</head>

<body>
    <header class="navbar">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
        <div class="nav-central">
            <h1>Meus Tickets de Suporte</h1> <!-- Título principal da página -->
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Procurar por ticket...">
            </div>
        </div>
    </header>

    <main class="meus-tickets">
        <div class="filtros">
            <button class="filtro-btn ativo" data-status="todos">Todos</button>
            <button class="filtro-btn" data-status="Aberto">Abertos</button>
            <button class="filtro-btn" data-status="Fechado">Fechados</button>
        </div>

        <div id="listaTickets" class="lista-tickets">
            <!-- Tickets serão carregados aqui via PHP -->
            <?php
            // Inclui conexão com banco
            include '../funcoes/conexao.php';

            // Verifica se o aluno está logado
            if (isset($_SESSION['id']) && $_SESSION['tipo'] === 'aluno') {
                $idAluno = $_SESSION['id'];

                // Busca todos os tickets do aluno (pelo e-mail do usuário, já que na tabela ticket tem o campo email)
                $stmt = $conexao->prepare("SELECT id, assunto, status, data_criacao FROM tickets WHERE email = (SELECT email FROM usuarios WHERE id = ?) ORDER BY data_criacao DESC");
                $stmt->bind_param("i", $idAluno);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while ($ticket = $resultado->fetch_assoc()) {
                        echo '<div class="ticket-item" data-status="' . htmlspecialchars($ticket['status']) . '">';
                        echo '<h3>' . htmlspecialchars($ticket['assunto']) . '</h3>';
                        echo '<p>Status: <span class="ticket-status">' . htmlspecialchars($ticket['status']) . '</span></p>';
                        echo '<p>Data de Criação: ' . date('d/m/Y H:i', strtotime($ticket['data_criacao'])) . '</p>';
                        echo '<a href="ver_ticket.php?id=' . $ticket['id'] . '" class="btn-ver-mais">Ver Detalhes</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Você ainda não enviou nenhum ticket.</p>';
                }

                $stmt->close();
                $conexao->close();
            } else {
                echo '<p>Faça login para ver seus tickets.</p>';
            }
            ?>
        </div>
    </main>

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtroBtns = document.querySelectorAll('.filtro-btn');
            const tickets = document.querySelectorAll('.ticket-item');

            filtroBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    filtroBtns.forEach(b => b.classList.remove('ativo'));
                    btn.classList.add('ativo');

                    const status = btn.getAttribute('data-status');

                    tickets.forEach(ticket => {
                        if (status === 'todos' || ticket.dataset.status === status) {
                            ticket.style.display = 'block';
                        } else {
                            ticket.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.ticket-item');

            searchInput.addEventListener('input', function() {
                const searchText = searchInput.value.toLowerCase();

                cards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchText)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>

</html>