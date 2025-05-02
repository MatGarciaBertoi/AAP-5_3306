<?php
    session_start();
    
    if (!isset($_SESSION['aluno_id'])) {
        header("Location: http://localhost/AAP-5_3306/cadastro_login/aluno/signin.php");
        exit;
    }
?>