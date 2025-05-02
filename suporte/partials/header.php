 <!-- Cabeçalho da página com título e navegação -->
 <div class="nav-header">
     <div class="logo">
         <a href="suporte.php">
             <img src="../images/logocwbranco_transparente.png" alt="Logo da CW Cursos" />
         </a>

         <h1>Central de Ajuda</h1>

     </div>

     <nav class="nav-botoes">
         <nav class="nav-support">
             <ul>
                 <li><a href="suporte.php">Início</a></li>
                 <li><a href="artigos.php">Artigos</a></li>
                 <li><a href="ticket.php">Abrir um Ticket</a></li>
             </ul>
         </nav>
         <?php
            $tiposPermitidos = ['aluno', 'professor', 'administrador'];
            if (isset($_SESSION['id']) && in_array($_SESSION['tipo'], $tiposPermitidos)):
            ?>
             <div class="btn-alunos">
                 <div id="perfilAlunoBtn" class="perfil-aluno-btn">
                     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#333" viewBox="0 0 24 24">
                         <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                     </svg>
                 </div>

                 <!-- Container de opções -->
                 <div id="perfilAlunoOpcoes" class="perfil-opcoes">
                     <a href="#">Conta</a>
                     <a href="meusTickets.php">Meus Tickets</a>
                     <a href="../funcoes/sessoes/logout_suporte.php">Sair</a>
                 </div>
             </div>
         <?php else: ?>
             <div class="btn-alunos">
                 <a href="cadastro_login/signin.php" class="planos-btn">Entrar</a>
                 <a href="cadastro_login/signup.php" class="planos-btn">Cadastrar-se</a>
             </div>
         <?php endif; ?>
     </nav>
 </div>
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const perfilBtn = document.getElementById('perfilAlunoBtn');
         const opcoes = document.getElementById('perfilAlunoOpcoes');

         perfilBtn.addEventListener('click', function(e) {
             e.stopPropagation(); // para não fechar na hora de abrir
             opcoes.classList.toggle('show');
         });

         document.addEventListener('click', function(event) {
             if (!perfilBtn.contains(event.target) && !opcoes.contains(event.target)) {
                 opcoes.classList.remove('show');
             }
         });
     });
 </script>


 <!-- Chatra {literal} -->
 <script>
     (function(d, w, c) {
         w.ChatraID = 'igHEh7N4PEvoDEkR7';
         var s = d.createElement('script');
         w[c] = w[c] || function() {
             (w[c].q = w[c].q || []).push(arguments);
         };
         s.async = true;
         s.src = 'https://call.chatra.io/chatra.js';
         if (d.head) d.head.appendChild(s);
     })(document, window, 'Chatra');
     window.ChatraSetup = {
         colors: {
             buttonText: '#202124',
             /* chat button text color */
             buttonBg: '#F1F3F4' /* chat button background color */
         }
     };
 </script>
 <!-- /Chatra {/literal} -->