<?php
$servidor = "localhost"; // Define o hostname do servidor de banco de dados
$usuario = "root"; // Define o nome de usuário do banco de dados
$senha = ""; // Define a senha do banco de dados
$dbname = "aapcw_cadastro"; // Define o nome do banco de dados

// Cria uma nova conexão com o banco de dados usando as credenciais fornecidas
$conexao = new mysqli($servidor, $usuario, $senha, $dbname);

// Verifica se houve erro ao conectar ao banco de dados e retorna a mensagem de erro para tratamento posterior
if($conexao->connect_errno) {
    die("Erro ao conectar ao banco de dados: " . $conexao->connect_error); // Termina o script se houver um erro
}

return $conexao; // <-- ESSA LINHA é essencial!

// A conexão é estabelecida sem mensagens na tela; qualquer tratamento de sucesso ou falha deve ser feito no script que utiliza esta conexão
?>
