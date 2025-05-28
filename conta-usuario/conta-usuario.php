<?php
include_once "../conexao.php";

// 1) Pega o ID passado por GET; valida para garantir que é um inteiro
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    exit("ID inválido");
}
$petId = $_GET['id'];

// 2) Busca os dados do pet
$sql = "SELECT p.Identificacao,
               p.Nome,
               p.Peso,
               p.DataNascimento,
               p.Especie,
               p.Alergias,
               p.Vacinas,
               p.Foto,
               pp.PessoaID
          FROM pets AS p
     LEFT JOIN pessoapet AS pp ON pp.PetID = p.PetID AND pp.Excluido = 0
         WHERE p.PetID = $petId
           AND p.Excluido = 0
           LIMIT 1";
$result = mysqli_query($conn, $sql) or exit("Erro no SELECT: " . mysqli_error($conn));

if (mysqli_num_rows($result) === 0) {
    exit("Pet não encontrado.");
}

$pet = mysqli_fetch_assoc($result);

// 3) Exibe em HTML
?>
<!--!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Detalhes do Pet #<?= htmlspecialchars($petId) ?></title>
  <style>
    body { font-family: sans-serif; }
    .card { 
      max-width: 400px; 
      border: 1px solid #ccc; 
      padding: 1rem; 
      border-radius: 8px; 
      box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    }
    .card img { max-width: 100%; border-radius: 4px; }
    .card dt { font-weight: bold; margin-top: 0.5rem; }
    .card dd { margin: 0 0 0.5rem 0; }
  </style>
</head>
<body>
  <h1>Detalhes do Pet</h1>
  <div class="card">
    <?php if (!empty($pet['Foto']) && file_exists(__DIR__ . '/images/' . $pet['Foto'])): ?>
      <img src="images/<?= htmlspecialchars($pet['Foto']) ?>" alt="Foto de <?= htmlspecialchars($pet['Nome']) ?>">
    <?php endif; ?>

    <dl>
      <dt>ID de Identificação:</dt>
      <dd><?= htmlspecialchars($pet['Identificacao']) ?></dd>

      <dt>Nome:</dt>
      <dd><?= htmlspecialchars($pet['Nome']) ?></dd>

      <dt>Data de Nascimento:</dt>
      <dd><?= htmlspecialchars($pet['DataNascimento']) ?></dd>

      <dt>Peso:</dt>
      <dd><?= htmlspecialchars($pet['Peso']) ?> kg</dd>

      <dt>Espécie:</dt>
      <dd><?= htmlspecialchars($pet['Especie']) ?></dd>

      <dt>Alergias:</dt>
      <dd><?= htmlspecialchars($pet['Alergias']) ?></dd>

      <dt>Vacinas:</dt>
      <dd><?= htmlspecialchars($pet['Vacinas']) ?></dd>

      <?php if ($pet['PessoaID']): ?>
      <dt>Vinculado ao Usuário (ID):</dt>
      <dd><?= htmlspecialchars($pet['PessoaID']) ?></dd>
      <?php endif; ?>
    </dl>
  </div>
</body>
</html-->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TechPet - Conta User #<?= htmlspecialchars($petId) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="conta-usuario.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="container-fluid d-flex justify-content-center align-items-center min-vh-100" style="background-color: rgb(234, 224, 224);">
    <div class="row justify-content-center d-flex shadow bg-white p-4" style="border-radius:1rem ;">
        <!-- Substituir h1 por ${user.name} -->
        <h1 class="h2">Usuario</h1>     
        <div class="col-12 d-flex justify-content-center flex-column align-items-center">
            <div class="row">
                <!-- Inserir informações do usúario dentro dessa div-->
                <!--a href="../logar/logar.html" class="col-12 btn mt-3" style="background-color: #5beeba;">
                    <button type="button" class="border-0 btn" style="text-decoration: underline;">Pet 1</button>
                </a>
                <a href="../registre-se/registre-se.html" class="col-12 btn mt-3" style="background-color: #5beeba;">
                    <button type="button" class="border-0 btn" style="text-decoration: underline;">Pet 2</button>
                </a>
                <a href="../achei-um-pet/achei-um-pet.html" class="col-12 btn mt-3" style="background-color: #5beeba;">
                    <button type="button" class="border-0 btn" style="text-decoration: underline;">Pet 3</button>
                </a-->
                <div class="petInfo col-12 d-flex justify-content-center flex-column align-items-center bg-danger">
                    <?php if (!empty($pet['Foto']) && file_exists(__DIR__ . '/images/' . $pet['Foto'])): ?>
                        <img class="img" src="images/<?= htmlspecialchars($pet['Foto']) ?>" alt="Foto de <?= htmlspecialchars($pet['Nome']) ?>">
                    <?php endif; ?>

                    <h2 class="petName"><?= htmlspecialchars($pet['Nome']) ?></h2>
                    <h3 class="petId display-7"><?= htmlspecialchars($pet['Identificacao']) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj " crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script src="../conta-usuario/conta-usuario.js"></script>
</body>
</html>