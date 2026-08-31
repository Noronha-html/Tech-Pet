<?php
//Conexão com o banco
session_start();
include_once "../conn.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../registre-se/registre-se.php");
    exit;
}
$usuarioId = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registre-seu-pet.php");
    exit;
}

//Recupera campos
$name        = trim($_POST['name'] ?? '');
$birthDate   = trim($_POST['dtnasc'] ?? '');
$weight      = trim($_POST['peso'] ?? '');
$serialNumber= trim($_POST['numeroSerie'] ?? '');
$species     = "null";
$alergies    = trim($_POST['alergias'] ?? '');
$vaccines    = trim($_POST['vacinas'] ?? '');

$errors = [];

//Validações básicas
if ($name === '') {
    $errors[] = "O nome do pet é obrigatório.";
} elseif (!preg_match('/^[\p{L}\s]+$/u', $name)) {
    //Aceita letras com acento e espaços
    $errors[] = "O nome só pode conter letras e espaços.";
}

if ($birthDate === '') {
    $errors[] = "A data de nascimento é obrigatória.";
} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthDate) || !strtotime($birthDate)) {
    $errors[] = "Formato de data inválido. Use AAAA-MM-DD.";
}

if ($weight === '' || !is_numeric($weight) || $weight <= 0) {
    $errors[] = "Informe um peso válido.";
}

if ($serialNumber === '') {
    $errors[] = "Número de série é obrigatório.";
} elseif (!preg_match('/^#?[a-zA-Z0-9]{1,3}$/', $serialNumber)) {
    $errors[] = "Número de série deve ter até 3 caracteres alfanuméricos.";
}

if (!isset($_FILES['inputImagem']) || $_FILES['inputImagem']['error'] === UPLOAD_ERR_NO_FILE) {
    $errors[] = "A foto do pet é obrigatória.";
}

//Valida foto, se existir
$photoName = null;
if (empty($errors) && isset($_FILES['inputImagem']) && $_FILES['inputImagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['inputImagem']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Erro ao enviar a foto.";
    } else {
        $fileTmp  = $_FILES['inputImagem']['tmp_name'];
        $fileSize = $_FILES['inputImagem']['size'];
        $fileType = mime_content_type($fileTmp);

        //Tamanho máximo: 10 MB
        if ($fileSize > 10 * 1024 * 1024) {
            $errors[] = "A imagem deve ter no máximo 10 MB.";
        }
        //Permitir jpeg ou png
        if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
            $errors[] = "Tipo de arquivo inválido. Só JPEG ou PNG.";
        }

        //Se tudo ok, gera nome único
        if (empty($errors)) {
            $ext = ($fileType === 'image/png') ? 'png' : 'jpg';
            $photoName = md5($name . $serialNumber . uniqid()) . '.' . $ext;
            $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'pets' . DIRECTORY_SEPARATOR;
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                $errors[] = "Não foi possível criar pasta de imagens.";
            } else {
                $destino = $uploadDir . $photoName;
                if (!move_uploaded_file($fileTmp, $destino)) {
                    $errors[] = "Falha ao mover arquivo.";
                }
            }
        }
    }
}

//Se houver erros, retorna ao form com lista de erros
if (!empty($errors)) {
    //Salva erros na sessão
    $_SESSION['pet_errors'] = $errors;
    //Salva valores antigos para reaproveitar no form
    $_SESSION['pet_old'] = [
        'name'        => $name,
        'dtnasc'      => $birthDate,
        'peso'        => $weight,
        'vacinas'     => $vaccines,
        'alergias'    => $alergies,
        'numeroSerie' => $serialNumber
    ];
    header("Location: registre-seu-pet.php");
    exit;
}

//Verifica se já existe pet com mesmo número de série
$sqlVer = "SELECT 1
             FROM pets
            WHERE Identificacao = ?
              AND Excluido = 0
            LIMIT 1";
$stmtVer = $conn->prepare($sqlVer);
$stmtVer->bind_param("s", $serialNumber);
$stmtVer->execute();
$resVer = $stmtVer->get_result();
$stmtVer->close();

if ($resVer->num_rows > 0) {
    //Grava o erro na sessão e retorna ao form
    $_SESSION['pet_errors'] = ["Este número de série já está cadastrado para outro pet."];
    $_SESSION['pet_old'] = [
        'name'        => $name,
        'dtnasc'      => $birthDate,
        'peso'        => $weight,
        'vacinas'     => $vaccines,
        'alergias'    => $alergies,
        'numeroSerie' => $serialNumber
    ];
    header("Location: registre-seu-pet.php");
    exit;
}

//Insere na tabela pets
$sqlInsPet = " INSERT INTO pets
      (Identificacao, Nome, Especie, Peso, DataNascimento, Foto, Alergias, Vacinas, Excluido)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)
";
$stmtIns = $conn->prepare($sqlInsPet);
$stmtIns->bind_param(
    "sssdssss",
    $serialNumber,
    $name,
    $species,
    $weight,
    $birthDate,
    $photoName,
    $alergies,
    $vaccines
);
if (!$stmtIns->execute()) {
    exit("Erro ao cadastrar pet. Detalhe: " . htmlspecialchars($stmtIns->error));
}
$novoPetId = $stmtIns->insert_id;
$stmtIns->close();

//Cria a associação Pessoa-Pet
$sqlInsRel = " INSERT INTO pessoapet
        (PessoaID, PetID, Excluido)
    VALUES (?, ?, 0)
";
$stmtRel = $conn->prepare($sqlInsRel);
$stmtRel->bind_param("ii", $usuarioId, $novoPetId);
$stmtRel->execute();
$stmtRel->close();

//Redireciona para a conta do usuário
header("Location: ../conta-usuario/conta-usuario.php");
exit;
?>