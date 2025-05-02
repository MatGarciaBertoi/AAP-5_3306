<?php
function listarUsuarios($conexao, $type, $busca = '')
{
    $type = mysqli_real_escape_string($conexao, $type);
    $query = "SELECT * FROM usuarios WHERE tipo = '$type'";

    if (!empty($busca)) {
        $busca = mysqli_real_escape_string($conexao, $busca);
        $query .= " AND (nome LIKE '%$busca%' OR email LIKE '%$busca%' OR usuario LIKE '%$busca%')";
    }

    $query .= " ORDER BY nome ASC";
    $result = mysqli_query($conexao, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Data de Nascimento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $nome = htmlspecialchars($row['nome']);
            $usuario = htmlspecialchars($row['usuario']);
            $email = htmlspecialchars($row['email']);
            $dataNascimento = date('d/m/Y', strtotime($row['data_nascimento']));
            $status = ucfirst($row['status']);
            $photo = htmlspecialchars($row['photo']);

            $btnAcao = $row['status'] === 'bloqueado'
                ? "<a href='../funcoes/acoes/desbloquear.php?id=$id' class='btn-acao'>Desbloquear</a>"
                : "<a href='../funcoes/acoes/bloquear.php?id=$id' class='btn-acao' onclick=\"return confirm('Tem certeza que deseja bloquear este usuário?')\">Bloquear</a>";

            echo "<tr>
                <td><img src='$photo' alt='Foto' width='40' height='40' style='border-radius: 50%;'></td>
                <td>$nome</td>
                <td>$usuario</td>
                <td>$email</td>
                <td>$dataNascimento</td>
                <td>$status</td>
                <td>
                    <a href='../funcoes/editar.php?id=$id&type=$type' class='btn-acao'>Editar</a>
                    $btnAcao
                </td>
            </tr>";
        }

        echo '</tbody></table>';
    } else {
        echo "<p>Nenhum $type encontrado.</p>";
    }
}
?>
