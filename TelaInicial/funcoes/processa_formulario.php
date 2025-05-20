<?php
session_start();
require '../../funcoes/conexao.php'; // conexao com o banco

if (!isset($_SESSION['id'])) {
    die("Você precisa estar logado para enviar o formulário.");
}

$usuario_id = $_SESSION['id'];

// Pegando os dados do formulário
$nome = $_POST['name'];
$email = $_POST['email'];
$experiencia = $_POST['experience'];
$avaliacao = $_POST['experience_rating'];
$navegacao = $_POST['navigation'];
$qualidade = $_POST['quality'];
$atendimento = $_POST['customer_service'];

$tipo_curso = isset($_POST['course_type']) ? implode(", ", (array) $_POST['course_type']) : "";
$outro_tipo = $_POST['course_type_other'];

$tema_especifico = $_POST['specific_theme'];

$motivacoes = isset($_POST['motivations']) ? implode(", ", (array) $_POST['motivations']) : "";
$outra_motivacao = $_POST['motivations_other'];

$recursos = isset($_POST['resources']) ? implode(", ", (array) $_POST['resources']) : "";
$outro_recurso = $_POST['resources_other'];

$sugestoes = $_POST['suggestions'];
$comentarios = $_POST['additional_comments'];

$atualizacoes = $_POST['updates'];
$contato = $_POST['contact'];

// Inserir no banco
$sql = "INSERT INTO formularios (
           usuario_id, nome, email, experiencia, avaliacao_experiencia,
           navegacao, qualidade, atendimento, tipo_curso, outro_tipo,
           tema_especifico, motivacoes, outra_motivacao, recursos, outro_recurso,
           sugestoes, comentarios, atualizacoes, contato
        )
        VALUES (
           ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

$stmt = $conexao->prepare($sql);

// 1 inteiro (i) + 18 strings (s) = 19 tipos
$stmt->bind_param(
    "issssssssssssssssss",
    $usuario_id,
    $nome,
    $email,
    $experiencia,
    $avaliacao,
    $navegacao,
    $qualidade,
    $atendimento,
    $tipo_curso,
    $outro_tipo,
    $tema_especifico,
    $motivacoes,
    $outra_motivacao,
    $recursos,
    $outro_recurso,
    $sugestoes,
    $comentarios,
    $atualizacoes,
    $contato
);

if ($stmt->execute()) {
    echo "Formulário enviado com sucesso!";
} else {
    echo "Erro ao enviar: " . $stmt->error;
}

$stmt->close();
$conexao->close();
