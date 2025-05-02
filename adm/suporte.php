<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Suporte</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/suporte.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">

        <main>
            <section id="suporte" class="section">
                <h2>Suporte</h2>
                <button onclick="listMessages()">Listar Mensagens</button>
                <div id="messageList" class="list"></div>
            </section>
            <!-- Modal de Resposta -->
            <div id="modalResponder" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="fecharModal()">&times;</span>
                    <h2>Responder Ticket</h2>
                    <form id="formResposta">
                        <input type="hidden" id="ticketId" name="ticketId">
                        <div>
                            <label for="resposta">Mensagem de Resposta:</label><br>
                            <textarea id="resposta" name="resposta" rows="5" required></textarea>
                        </div>
                        <br>
                        <button type="submit">Enviar Resposta</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->

    <script>
        function listMessages() {
            fetch('funcoes/listarMensagens.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('messageList').innerHTML = data;
                })
                .catch(error => {
                    console.error('Erro ao carregar mensagens:', error);
                });
        }

        function responderTicket(id) {
            // Quando clicar em responder, abre o modal e preenche o ID escondido
            document.getElementById('ticketId').value = id;
            document.getElementById('modalResponder').style.display = 'block';
        }

        function fecharModal() {
            document.getElementById('modalResponder').style.display = 'none';
        }

        // Fechar modal clicando fora da área
        window.onclick = function(event) {
            var modal = document.getElementById('modalResponder');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Enviar resposta
        document.getElementById('formResposta').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede de recarregar a página

            const ticketId = document.getElementById('ticketId').value;
            const resposta = document.getElementById('resposta').value;

            const formData = new FormData();
            formData.append('ticketId', ticketId);
            formData.append('resposta', resposta);

            fetch('funcoes/responderTicket.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensagem);

                    if (data.status === 'sucesso') {
                        fecharModal();
                        document.getElementById('formResposta').reset();
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar resposta:', error);
                });
        });
    </script>


</body>

</html>