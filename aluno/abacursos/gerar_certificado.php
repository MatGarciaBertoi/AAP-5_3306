<?php
require('../../lib/vendor/setasign/fpdf/fpdf.php');
require('../../lib/vendor/phpqrcode/qrlib.php');
session_start();
include_once('../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

$aluno_id = $_SESSION['id'];
$curso_id = isset($_POST['curso_id']) ? intval($_POST['curso_id']) : 0;

// Busca dados do curso
$stmt = $conexao->prepare("SELECT nome FROM cursos WHERE id = ?");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$curso = $result->fetch_assoc();

// Busca dados do aluno
$stmt = $conexao->prepare("SELECT nome FROM usuarios WHERE id = ? AND tipo = 'aluno'");
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();

if (!$curso || !$aluno) {
    echo "Erro ao gerar certificado.";
    exit();
}

// Gera o QR code (link de verificação pode ser personalizado)
$verificacao_url = "https://seudominio.com/verificar_certificado.php?aluno_id={$aluno_id}&curso_id={$curso_id}";
$qr_path = '../../temp_qr.png';
QRcode::png($verificacao_url, $qr_path, QR_ECLEVEL_L, 3);

// Gera o PDF com FPDF
class PDF extends FPDF
{
    function Header()
    {
        // Fundo personalizado
        $this->Image('../../images/fundo_certificado.png', 0, 0, 297, 210); // fundo para horizontal
    }

    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, mb_convert_encoding('Emitido em ' . date('d/m/Y'), 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Image('../../temp_qr.png', 255, 170, 25); // QR Code no canto inferior direito
    }

    // Borda
    function FancyBorder()
    {
        $this->SetLineWidth(1);
        $this->Rect(10, 10, 277, 190); // borda ajustada ao novo tamanho da página
    }
}

$pdf = new PDF('L', 'mm', 'A4'); // L = landscape
$pdf->AddPage();
$pdf->FancyBorder();
$pdf->SetFont('Arial', '', 14);

// Texto principal centralizado
$texto = "Certificamos que " . $aluno['nome'] . " concluiu com êxito o curso \"" . $curso['nome'] . "\".";
$texto = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
$pdf->SetXY(20, 100);
$pdf->MultiCell(257, 10, $texto, 0, 'C');
$pdf->Ln(20);

// Assinatura
$pdf->Cell(0, 10, '_______________________________', 0, 1, 'C');
$pdf->Cell(0, 10, 'Matheus Garcia Bertoi', 0, 1, 'C');
$pdf->Cell(0, 3, 'Socio Fundador da CW Cursos', 0, 1, 'C');

// Output
$pdf->Output('I', 'certificado.pdf');
unlink($qr_path);
exit();
