<?php
include_once('../../funcoes/sessoes/check_aluno.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Assinatura Realizada</title>
    <link rel="stylesheet" href="style.css"> <!-- Use o seu CSS ou Bootstrap aqui -->
    <style>
        :root {
            --azul: #1A73E8;
            --cinza-claro: #F1F3F4;
            --cinza-escuro: #202124;
            --amarelo: #FFB400;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .sucesso-box {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .sucesso-box h1 {
            color: var(--azul);
            margin-bottom: 20px;
        }

        .sucesso-box p {
            font-size: 18px;
            color: #333;
        }

        .sucesso-box a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: var(--azul);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .sucesso-box a:hover {
            background-color: var(--azul);
        }
    </style>
</head>

<body>
    <div class="sucesso-box">
        <h1>Assinatura realizada com sucesso!</h1>
        <p>Seu plano foi registrado. Agora você pode aproveitar todos os recursos disponíveis do seu plano assinado.</p>
        <a href="../index.php">Voltar à Página Inicial</a>
    </div>
</body>

</html>