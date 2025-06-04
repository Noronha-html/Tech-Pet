<?php
session_start();
include_once "../conexao.php"; // Ajuste o caminho se a sua conexão estiver em local diferente

// 1) Captura o serial pela query string
$serial = trim($_GET['serial'] ?? '');
if ($serial === '') {
    die("Número de série não informado.");
}

// 2) Consulta no banco o pet e os dados do dono (nome + whatsapp)
$sql = " SELECT 
        p.PetID,
        p.Identificacao,
        p.Nome       AS petNome,
        p.Especie,
        p.Peso,
        p.DataNascimento,
        p.Foto,
        p.Alergias,
        p.Vacinas,
        u.Nome       AS donoNome,
        u.Whatsapp   AS donoWpp
      FROM pets AS p
      INNER JOIN pessoapet AS pp ON p.PetID = pp.PetID
      INNER JOIN pessoas AS u  ON pp.PessoaID = u.PessoaID
     WHERE p.Identificacao = ?
       AND p.Excluido = 0
       AND pp.Excluido = 0
       AND u.Excluido = 0
     LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $serial);
$stmt->execute();
$res = $stmt->get_result();
$stmt->close();

if ($res->num_rows === 0) {
    die("Pet não encontrado ou cadastro inativo.");
}

$pet = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit=no">
    <title>TechPet – Detalhes do Pet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../pet/pet.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">

    <div class="card shadow-sm p-4 m-4" style="border-radius: 1rem; width: 90%; max-width: 600px;">
        <h2 class="mb-3">Informações do Pet</h2>
        <div class="row">
            <div class="col-md-4">
                <?php $imgPath = __DIR__ . '/../registre-seu-pet/pets/' . $pet['Foto'];
                    if (!empty($pet['Foto']) && file_exists($imgPath)): ?>
                        <img style="width: 100%; border-radius: 1rem;" src="../registre-seu-pet/pets/<?= htmlspecialchars($pet['Foto']) ?>"
                        alt="Foto de <?= htmlspecialchars($pet['petNome']) ?>">
                <?php else: ?>
                    <img src="https://via.placeholder.com/350x200?text=Sem+Foto"
                         class="img-fluid rounded"
                         alt="Sem Foto">
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <p><strong>Identificação:</strong> <?= htmlspecialchars($pet['Identificacao']) ?></p>
                <p><strong>Nome:</strong> <?= htmlspecialchars($pet['petNome']) ?></p>
                <p><strong>Espécie:</strong> <?= htmlspecialchars($pet['Especie']) ?></p>
                <p><strong>Peso:</strong> <?= htmlspecialchars($pet['Peso']) ?> kg</p>
                <p><strong>Data de Nascimento:</strong> <?= date("d/m/Y", strtotime($pet['DataNascimento'])) ?></p>
                <p><strong>Alergias:</strong> <?= nl2br(htmlspecialchars($pet['Alergias'])) ?></p>
                <p><strong>Vacinas:</strong> <?= nl2br(htmlspecialchars($pet['Vacinas'])) ?></p>
                <hr>
                <h4 class="mt-4">Dados do Dono</h4>
                <p><strong>Nome do Dono:</strong> <?= htmlspecialchars($pet['donoNome']) ?></p>
                <p><strong>WhatsApp:</strong> <?= htmlspecialchars($pet['donoWpp']) ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../pet/pet.js?<?php echo 't=' . base64_encode(date('YmdHis')); ?>"></script>
</body>
</html>
