<header class="navbar">
    <div class="nav-header">
        <div class="logo"><a href="../../TelaInicial/index.php">
                <img src="../../images/logocwpreto_transparente.png" alt="Logo da CW Cursos" />
            </a></div>

        <nav class="nav-botoes">
            <?php if (isset($_SESSION['id']) && $_SESSION['tipo'] === 'aluno'): ?>
                <a href="../../aluno/areadoaluno.php" class="planos-btn">Área do Aluno</a>
            <?php else: ?>
                <a href="signin.php" class="planos-btn">Seja um Professor</a>
                <a href="../usuario/signin.php" class="planos-btn">Entrar</a>
                <a href="../usuario/signup.php" class="planos-btn">Cadastrar-se</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<?php include '../../funcoes/usuario/acessibilidade.php'; ?>

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
            buttonText: '#F1F3F4',
            /* chat button text color */
            buttonBg: '#1A73E8' /* chat button background color */
        }
    };
</script>
<!-- /Chatra {/literal} -->