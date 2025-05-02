<?php
session_start();
session_destroy(); // Destroi a sessão
header('Location: http://localhost/AAP-CW_Cursos/suporte/suporte.php'); // Redireciona para a página de login
exit();
?>