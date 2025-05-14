<?php
function alunoTemAcesso($conexao, $aluno_id, $curso_id)
{
    $sql = "SELECT 1 FROM inscricoes WHERE aluno_id = ? AND curso_id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $aluno_id, $curso_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
?>
