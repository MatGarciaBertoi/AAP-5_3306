<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CW Cursos - Cursos de Marketing Digital</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/ajuda.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <main>
        <div class="container">
            <!-- Seção de perguntas frequentes -->
            <section id="faq">
                <div class="faq-title">
                    <h1>Perguntas Frequentes</h1> <!-- Título da seção -->
                </div>
                <!-- Pergunta e resposta sobre o acesso aos cursos -->
                <div class="faq-item">
                    <button class="faq-question">Como faço para acessar os cursos?<i class="bi bi-caret-down"></i></button>
                    <div class="faq-answer hidden">
                        <p>Você pode acessar os cursos através do painel do aluno após efetuar login.</p>
                    </div>
                </div>
                <!-- Pergunta e resposta sobre recuperação de senha -->
                <div class="faq-item">
                    <button class="faq-question">Esqueci minha senha. O que devo fazer?<i class="bi bi-caret-down"></i></button>
                    <div class="faq-answer hidden">
                        <p>Clique em "Esqueci minha senha" na página de login e siga as instruções.</p>
                    </div>
                </div>
                <!-- Pergunta e resposta sobre contato com o suporte -->
                <div class="faq-item">
                    <button class="faq-question">Como posso entrar em contato com o suporte?<i class="bi bi-caret-down"></i></button>
                    <div class="faq-answer hidden">
                        <p>Você pode entrar em contato conosco através da seção de contato abaixo ou enviando um email para suporte@plataformadecursos.com.</p>
                    </div>
                </div>
                <!-- Pergunta e resposta sobre acesso pelo celular -->
                <div class="faq-item">
                    <button class="faq-question">Posso acessar os cursos pelo celular?<i class="bi bi-caret-down"></i></button>
                    <div class="faq-answer hidden">
                        <p>Sim, nossos cursos são compatíveis com dispositivos móveis. Basta acessar o site pelo navegador do seu celular.</p>
                    </div>
                </div>
                <!-- Pergunta e resposta sobre certificados dos cursos -->
                <div class="faq-item">
                    <button class="faq-question">Os cursos têm certificado?<i class="bi bi-caret-down"></i></button>
                    <div class="faq-answer hidden">
                        <p>Sim, todos os nossos cursos oferecem certificado de conclusão que você pode baixar e imprimir.</p>
                    </div>
                </div>
            </section>
            <section id="central">
                <div class="central-header">
                    <h1>Ainda tem alguma dúvida e precisa de ajuda?</h1>
                    <p>
                        Entre em contato conosco para podermos ajudá-lo! Você pode falar com nosso
                        <a href="#chatraChatExpanded">Chatbot</a>.
                    </p>
                </div>
                <div class="central-main">
                    <div class="central-subtitle">
                        <h2>Contamos também com outros canais:</h2>
                    </div>
                    <div class="central-buttons">
                        <div class="central-button">
                            <a href="../suporte/suporte.php" target="_blank">Central de Ajuda</a>
                        </div>
                        <div class="central-button">
                            <a href="https://wa.me/5511999999999" target="_blank">WhatsApp</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

<!--Script para esconder e aparecer a resposta do FAQ-->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const faqItems = document.querySelectorAll('.faq-item'); // Obtém todos os itens de FAQ com a classe 'faq-item'
        faqItems.forEach(item => { // Para cada item de FAQ
            const question = item.querySelector('.faq-question'); // Obtém o elemento da pergunta dentro do item
            question.addEventListener('click', () => { // Adiciona um evento de clique à pergunta

                const answer = item.querySelector('.faq-answer'); // Obtém o elemento da resposta dentro do item
                const isVisible = answer.style.display === 'block';
                // Verifica se a resposta está visível
                answer.style.display = isVisible ? 'none' : 'block';
                // Alterna a visibilidade da resposta entre 'block' (visível) e 'none' (invisível)
            });
        });

        const contactForm = document.getElementById('contact-form'); // Obtém o formulário de contato pelo ID 'contact-form'
        const responseMessage = document.getElementById('response-message'); // Obtém a mensagem de resposta pelo ID 'response-message'

        contactForm.addEventListener('submit', function(event) {
            // Adiciona um evento de envio ao formulário de contato

            event.preventDefault();
            // Impede o envio real do formulário

            responseMessage.classList.remove('hidden');
            // Remove a classe 'hidden' da mensagem de resposta, exibindo-a na página
        });
    });

    //Alterna os botões

    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');

            // Alterna entre caret-down e caret-up
            if (icon.classList.contains('bi-caret-down')) {
                icon.classList.remove('bi-caret-down');
                icon.classList.add('bi-caret-up');
            } else {
                icon.classList.remove('bi-caret-up');
                icon.classList.add('bi-caret-down');
            }
        });
    });
</script>

</html>