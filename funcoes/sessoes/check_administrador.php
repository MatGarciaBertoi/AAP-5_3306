<?php
    session_start();
    
    if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'administrador') {
    header('Location: ../../cadastro_login/usuario/signin.php');
    exit();
}