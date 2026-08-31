<?php
session_start();
include_once "../conn.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['usuario_id'])) {
    header("Location: editar-usuario.php");
    exit;
}

$usuarioId = intval($_POST['usuario_id']);
$name      = trim($_POST['name']                  ?? '');
$email     = trim($_POST['email']                 ?? '');
$estado    = trim($_POST['estados']               ?? '');
$cidade    = trim($_POST['cidades']               ?? '');
$dtnasc    = trim($_POST['dtnasc']                ?? '');
$wpp       = trim($_POST['wpp']                   ?? '');

$errors = [];

// Validações (semelhantes ao registro)
if ($name==='')    $errors[]="Nome é obrigatório.";
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]="E‑mail inválido.";
if ($estado==='')  $errors[]="Selecione um Estado.";
if ($cidade==='')  $errors[]="Selecione uma Cidade.";
if (!preg_match('/^\d{4}\-\d{2}\-\d{2}$/',$dtnasc)) $errors[]="Data inválida.";
if (!preg_match('/^\d{10,11}$/',preg_replace('/\D/','',$wpp))) $errors[]="Celular inválido.";

if ($errors) {
    $_SESSION['edit_usuario_errors'] = $errors;
    header("Location: editar-usuario.php");
    exit;
}

// Verifica e‑mail duplicado
$sqlDup = "SELECT 1 FROM pessoas WHERE Email=? AND PessoaID<>? AND Excluido=0";
$stmt = $conn->prepare($sqlDup);
$stmt->bind_param("si",$email,$usuarioId);
$stmt->execute();
if ($stmt->get_result()->num_rows) {
    $_SESSION['edit_usuario_errors']=["Este e‑mail já está em uso."];
    header("Location: editar-usuario.php");
    exit;
}
$stmt->close();

// Grava update
$sqlUp = "UPDATE pessoas
            SET Nome=?, Email=?, Estado=?, Cidade=?, DataNascimento=?, Whatsapp=?
          WHERE PessoaID=?";
$stmt = $conn->prepare($sqlUp);
$stmt->bind_param(
    "ssssssi",
    $name, $email, $estado, $cidade, $dtnasc, $wpp, $usuarioId
);
if (!$stmt->execute()) {
    exit("Erro ao atualizar perfil: ".$stmt->error);
}
$stmt->close();

// Redireciona de volta à conta
header("Location: ../conta-usuario/conta-usuario.php");
exit;
