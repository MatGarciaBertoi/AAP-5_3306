 <!-- Cabeçalho da página com título e navegação -->
 <div class="nav-header">
     <div class="logo">
         <a href="#">
             <img src="../../images/logocwbranco_transparente.png" alt="Logo da CW Cursos" />
         </a>
         <a href="#">
             <h1>Central de Ajuda</h1>
         </a>
     </div>

     <nav class="nav-botoes">
         <nav class="nav-support">
             <ul>
                 <li><a href="../suporte.php">Início</a></li>
                 <li><a href="../artigos.php">Artigos</a></li>
                 <li><a href="../ticket.php">Abrir um Ticket</a></li>
             </ul>
         </nav>
         <?php if (isset($_SESSION['id']) && $_SESSION['tipo'] === 'aluno'): ?>
             <div class="btn-alunos">
                 <a href="#">
                     Aluno
                 </a>
             </div>
         <?php else: ?>
             <div class="btn-alunos">
                 <a href="signin.php" class="planos-btn">Entrar</a>
                 <a href="signup.php" class="planos-btn">Cadastrar-se</a>
             </div>
         <?php endif; ?>
     </nav>
 </div>

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