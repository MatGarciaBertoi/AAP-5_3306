<?php
session_start();
session_destroy(); // Destroi a sessão
header('Location: http://localhost/AAP-5_3306/suporte/suporte.php'); // Redireciona para a página de login
exit();
?>