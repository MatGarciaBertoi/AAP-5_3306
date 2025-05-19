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

 <?php include '../../funcoes/usuario/acessibilidade.php'; ?>

<!-- Chatra {literal} -->
<script src="../../funcoes/chatbot/suporte/chatra.js"> </script>