<?php
session_start();
include_once "../conexao.php";
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

// 1) Recupera e valida campos
$name        = trim($_POST['name'] ?? '');
$birthDate   = trim($_POST['dtnasc'] ?? '');
$weight      = trim($_POST['peso'] ?? '');
$serialNumber= trim($_POST['numeroSerie'] ?? '');
$species     = "null";
$alergies    = trim($_POST['alergias'] ?? '');
$vaccines    = trim($_POST['vacinas'] ?? '');

$errors = [];

// 2) Validações básicas
if ($name === '') {
    $errors[] = "O nome do pet é obrigatório.";
} elseif (!preg_match('/^[\p{L}\s]+$/u', $name)) {
    // aceita letras com acento e espaços (regex com 'u' para unicode)
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

// 3) Valida foto, se existir
$photoName = null;
if (isset($_FILES['inputImagem']) && $_FILES['inputImagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['inputImagem']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Erro ao enviar a foto.";
    } else {
        $fileTmp  = $_FILES['inputImagem']['tmp_name'];
        $fileSize = $_FILES['inputImagem']['size'];
        $fileType = mime_content_type($fileTmp);

        // Tamanho máximo: 2 MB
        if ($fileSize > 2 * 1024 * 1024) {
            $errors[] = "A imagem deve ter no máximo 2 MB.";
        }
        // Permitir jpeg ou png
        if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
            $errors[] = "Tipo de arquivo inválido. Só JPEG ou PNG.";
        }

        // Se todo ok, gera nome único
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

// 4) Se houver erros, retorna ao form com lista de erros (ou exibe a lista aqui)
if (!empty($errors)) {
    // Aqui você pode salvar $errors em $_SESSION e fazer um header("Location: registre-seu-pet.php");
    // Ou exibir o próprio formulário abaixo desta lógica. Vou exemplificar exibindo os erros nesta mesma página:
    echo "<h3>Foram detectados os seguintes erros:</h3>";
    echo "<ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul>";
    echo '<p><a href="registre-seu-pet.php">Voltar ao formulário</a></p>';
    exit;
}

// 5) Verifica se já existe pet com mesmo número de série (sem usar $_GET para PessoaID!)
$sqlVer = "SELECT 1
             FROM pets p
             JOIN pessoapet pp ON p.PetID = pp.PetID
            WHERE p.Identificacao = ?
              AND pp.PessoaID = ?
              AND p.Excluido = 0
              AND pp.Excluido = 0";
$stmtVer = $conn->prepare($sqlVer);
$stmtVer->bind_param("si", $serialNumber, $usuarioId);
$stmtVer->execute();
$resVer = $stmtVer->get_result();
if ($resVer->num_rows > 0) {
    exit("Você já cadastrou um pet com esse número de série.");
}
$stmtVer->close();

// 6) Insere na tabela pets
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

// 7) Cria a associação Pessoa↔Pet
$sqlInsRel = " INSERT INTO pessoapet
        (PessoaID, PetID, Excluido)
    VALUES (?, ?, 0)
";
$stmtRel = $conn->prepare($sqlInsRel);
$stmtRel->bind_param("ii", $usuarioId, $novoPetId);
$stmtRel->execute();
$stmtRel->close();

// 8) Redireciona para a página que lista todos os pets
header("Location: ../conta-usuario/conta-usuario.php");
exit;

?>