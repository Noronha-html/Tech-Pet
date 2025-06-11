<?php
session_start();
include_once "../conexao.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1) Usuário logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
$usuarioId = $_SESSION['usuario_id'];

// 2) Só POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: editar-seu-pet.php?id=" . intval($_POST['pet_id'] ?? 0));
    exit;
}

// 3) Recebe campos
$petId        = intval($_POST['pet_id'] ?? 0);
$name         = trim($_POST['name'] ?? '');
$birthDate    = trim($_POST['dtnasc'] ?? '');
$weight       = trim($_POST['peso'] ?? '');
$serialNumber = trim($_POST['numeroSerie'] ?? '');
$alergies     = trim($_POST['alergias'] ?? '');
$vaccines     = trim($_POST['vacinas'] ?? '');

// 4) Validações
$errors = [];

// 4.1) Verifica se pet pertence ao usuário
$sqlCheck = "SELECT Foto FROM pets p
               JOIN pessoapet pp ON p.PetID=pp.PetID
              WHERE p.PetID=? AND pp.PessoaID=? AND p.Excluido=0 AND pp.Excluido=0";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("ii", $petId, $usuarioId);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    exit("Pet não encontrado ou sem permissão.");
}
$row = $res->fetch_assoc();
$oldPhoto = $row['Foto'];
$stmt->close();

// 4.2) Nome
if ($name === '') {
    $errors[] = "O nome do pet é obrigatório.";
} elseif (!preg_match('/^[\p{L}\s]+$/u', $name)) {
    $errors[] = "O nome só pode conter letras e espaços.";
}

// 4.3) Data
if ($birthDate === '') {
    $errors[] = "A data de nascimento é obrigatória.";
} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthDate) || !strtotime($birthDate)) {
    $errors[] = "Formato de data inválido. Use AAAA-MM-DD.";
}

// 4.4) Peso
if ($weight === '' || !is_numeric($weight) || $weight <= 0) {
    $errors[] = "Informe um peso válido.";
}

// 4.5) Número de série único (excluindo este pet)
if ($serialNumber === '') {
    $errors[] = "Número de série é obrigatório.";
} elseif (!preg_match('/^#?[a-zA-Z0-9]{1,3}$/', $serialNumber)) {
    $errors[] = "Número de série deve ter até 3 caracteres alfanuméricos (com # opcional).";
} else {
    $sqlDup = "SELECT 1 FROM pets WHERE Identificacao=? AND PetID<>? AND Excluido=0";
    $st2 = $conn->prepare($sqlDup);
    $st2->bind_param("si", $serialNumber, $petId);
    $st2->execute();
    $r2 = $st2->get_result();
    if ($r2->num_rows > 0) {
        $errors[] = "Este número de série já está cadastrado para outro pet.";
    }
    $st2->close();
}

// 4.6) Foto obrigatória (já existente ou nova)
// Se não há foto antiga E não foi enviado novo arquivo => erro
if (empty($oldPhoto) && (!isset($_FILES['inputImagem']) || $_FILES['inputImagem']['error'] === UPLOAD_ERR_NO_FILE)) {
    $errors[] = "A foto do pet é obrigatória.";
}

// 4.7) Valida novo upload, se houver
$photoName = $oldPhoto;
if (isset($_FILES['inputImagem']) && $_FILES['inputImagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['inputImagem']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Erro ao enviar a foto.";
    } else {
        $fileTmp  = $_FILES['inputImagem']['tmp_name'];
        $fileSize = $_FILES['inputImagem']['size'];
        $fileType = mime_content_type($fileTmp);

        if ($fileSize > 10 * 1024 * 1024) {
            $errors[] = "A imagem deve ter no máximo 10 MB.";
        }
        if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
            $errors[] = "Tipo de arquivo inválido. Só JPEG ou PNG.";
        }

        if (empty($errors)) {
            // gera nome e move
            $ext = ($fileType === 'image/png') ? 'png' : 'jpg';
            $photoName = md5($name . $serialNumber . uniqid()) . '.' . $ext;
            $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . '../registre-seu-pet/pets' . DIRECTORY_SEPARATOR;
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                $errors[] = "Não foi possível criar pasta de imagens.";
            } else {
                $dest = $uploadDir . $photoName;
                if (!move_uploaded_file($fileTmp, $dest)) {
                    $errors[] = "Falha ao mover arquivo.";
                } else {
                    // remove foto antiga, se existir
                    if (!empty($oldPhoto) && file_exists($uploadDir . $oldPhoto)) {
                        @unlink($uploadDir . $oldPhoto);
                    }
                }
            }
        }
    }
}

// 5) Se erros, volta ao form
if (!empty($errors)) {
    $_SESSION['pet_errors'] = $errors;
    $_SESSION['pet_old'] = [
        'name'        => $name,
        'dtnasc'      => $birthDate,
        'peso'        => $weight,
        'vacinas'     => $vaccines,
        'alergias'    => $alergies,
        'numeroSerie' => $serialNumber
    ];
    header("Location: editar-seu-pet.php?id={$petId}");
    exit;
}

// 6) Atualiza no banco
$sqlUp = "UPDATE pets
             SET Identificacao=?, Nome=?, Especie='null', Peso=?, DataNascimento=?, Foto=?, Alergias=?, Vacinas=?
           WHERE PetID=?";
$stmtUp = $conn->prepare($sqlUp);
$stmtUp->bind_param(
    "ssdssssi",
    $serialNumber,
    $name,
    $weight,
    $birthDate,
    $photoName,
    $alergies,
    $vaccines,
    $petId
);
if (!$stmtUp->execute()) {
    exit("Erro ao atualizar pet: " . htmlspecialchars($stmtUp->error));
}
$stmtUp->close();

// 7) Redireciona de volta à lista
header("Location: ../conta-usuario/conta-usuario.php");
exit;
