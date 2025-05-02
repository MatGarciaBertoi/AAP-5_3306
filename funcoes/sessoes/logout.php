<?php
session_start();
session_destroy(); // Destroi a sessão
header('Location: http://localhost/AAP-CW_Cursos/TelaInicial/index.php'); // Redireciona para a página de login
exit();
?>
