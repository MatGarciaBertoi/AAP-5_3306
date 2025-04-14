<?php
include 'db_connection.php';

// Consulta para listar todos os cursos
$sql = "SELECT * FROM cursos WHERE status != 'deletado'";
$result = $conn->query($sql);

echo "<div class='page-container'>";  // Container para centralizar o título e os cards
echo "<h3 class='page-title'>Cursos Listados</h3>";  // Nome da página centralizado

if ($result->num_rows > 0) {
    echo '<div class="course-cards">'; // Container para os cards
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<h3>" . $row['nome_curso'] . "</h3>";
        echo "<p>Status: " . ucfirst($row['status']) . "</p>";  // Exibe o status do curso

        // Botão "Aprovar" se o status for pendente
        if ($row['status'] == 'pendente') {
            echo "<button class='btn-approve' onclick=\"approveCourse(" . $row['id'] . ")\">Aprovar</button>";
        }

        // Botão "Deletar" disponível para todos os cursos
        echo "<button class='btn-delete' onclick=\"deleteCourse(" . $row['id'] . ")\">Deletar</button>";

        // Botão "Ver Mais" para exibir detalhes do curso
        echo "<button class='btn-more' onclick=\"toggleDetails(" . $row['id'] . ")\">Ver Mais</button>";

        // Container para detalhes adicionais do curso (ocultos por padrão)
        echo "<div class='course-details' id='details-" . $row['id'] . "' style='display: none;'>";
        echo "<p><strong>Descrição:</strong> " . $row['descricao'] . "</p>";
        echo "<p><strong>Duração:</strong> " . $row['duracao'] . " horas</p>";
        echo "<p><strong>Data de Criação:</strong> " . $row['data_criacao'] . "</p>";
        echo "</div>";

        echo "</div>";
    }
    echo '</div>'; // Fecha o container dos cards
} else {
    echo "Nenhum curso encontrado.";
}

$conn->close();
?>

<script>
// Função para aprovar o curso
function approveCourse(courseId) {
    if (confirm('Tem certeza que deseja aprovar este curso?')) {
        window.location.href = 'approve_course.php?id=' + courseId;
    }
}

// Função para deletar o curso
function deleteCourse(courseId) {
    if (confirm('Tem certeza que deseja deletar este curso?')) {
        window.location.href = 'delete_course.php?id=' + courseId;
    }
}

// Função para exibir ou ocultar detalhes do curso
function toggleDetails(courseId) {
    const details = document.getElementById('details-' + courseId);
    if (details.style.display === 'none') {
        details.style.display = 'block';
    } else {
        details.style.display = 'none';
    }
}
</script>

<style>
/* Estilização do container da página e centralização */
.page-container {
    display: flex;
    flex-direction: column;
    align-items: center;  /* Centraliza o título e os cards */
    margin-top: 20px;
}

/* Estilização do título da página */
.page-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}
/* Estilização dos Cards de Cursos e Botões */
.course-cards {
    display: flex;
    flex-direction: column;  /* Cards um embaixo do outro */
    gap: 15px;  /* Espaçamento entre os cards */
    align-items: center;  /* Centralizar os cards */
    margin-top: 20px;
    padding: 0;
}

.card {
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 400px;  /* Largura maior para aparência de lista */
    text-align: left;  /* Texto alinhado à esquerda */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 10px;
}

p {
    color: #555;
    font-size: 16px;
    margin-bottom: 20px;
}

/* Botões */
.btn-approve, .btn-delete, .btn-more {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-right: 10px;
}

.btn-approve {
    background-color: #28a745;
    color: white;
}

.btn-approve:hover {
    background-color: #218838;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
}

.btn-more {
    background-color: #007bff;
    color: white;
}

.btn-more:hover {
    background-color: #0056b3;
}

/* Estilização dos detalhes do curso */
.course-details {
    background-color: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}
</style>
