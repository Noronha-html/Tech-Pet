<?php
//Conexão com o banco
session_start();
include_once "../conn.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../logar/logar.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$petId = intval($_GET['id'] ?? 0);

if ($petId <= 0) {
    exit("Pet inválido.");
}

//Verifica se o pet realmente pertence ao usuário
$sql = "SELECT * FROM pets p
        JOIN pessoapet pp ON p.PetID = pp.PetID
        WHERE p.PetID = ? AND pp.PessoaID = ? AND p.Excluido = 0 AND pp.Excluido = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $petId, $usuarioId);
$stmt->execute();
$res = $stmt->get_result();
$pet = $res->fetch_assoc();

if (!$pet) {
    exit("Pet não encontrado ou não pertence ao usuário.");
}

$atualizador = 't=' . base64_encode(date('YmdHis') . rand(0, 9999));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>TechPet - Editar Pet</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
        crossorigin="anonymous">
  <link rel="stylesheet" href="./editar-seu-pet.css">
  <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="container-fluid d-flex flex-column min-vh-100 justify-content-center align-items-center">

  <form id="formRegistraPet" enctype="multipart/form-data" action="./editar-seu-pet_processo.php" method="post" class="d-flex row flex-column align-items-center shadow p-4 m-5" style="border-radius: 1rem;">
    <legend class="col-12">Editar Pet</legend>
    <input type="hidden" name="pet_id" value="<?= $pet['PetID'] ?>">

    <fieldset class="border p-3" style="border-radius: 1rem;">
      <div class="col-12 m-1">
        <label for="name" id="label-name">Nome:</label>
        <input type="text" name="name" id="name" class="border-left-0 border-right-0 border-top-0 border ml-2 mr-2 p-1" value="<?= htmlspecialchars($pet['Nome']) ?>">
      </div>

      <div class="col-12 m-1">
        <label for="dtnasc" id="label-dtnasc">Data de nascimento:</label>
        <input type="date" name="dtnasc" id="dtnasc" class="border-left-0 border-right-0 border-top-0 border ml-2 p-1" value="<?= htmlspecialchars($pet['DataNascimento']) ?>">
      </div>

      <div class="col-12 m-1">
        <label for="peso" id="label-peso">Peso:</label>
        <input type="text" name="peso" id="peso" class="border-left-0 border-right-0 border-top-0 border ml-2 p-1" value="<?= htmlspecialchars($pet['Peso']) ?>">
      </div>

      <div class="col-12 m-1">
        <label for="vacinas" id="label-vacinas">Vacinas:</label>
        <input type="text" name="vacinas" id="vacinas" class="border-left-0 border-right-0 border-top-0 border ml-2 p-1" value="<?= htmlspecialchars($pet['Vacinas']) ?>">
      </div>

      <div class="col-12 m-1">
        <label for="alergias" id="label-alergias">Alergias:</label>
        <input type="text" name="alergias" id="alergias" class="border-left-0 border-right-0 border-top-0 border ml-2 p-1" value="<?= htmlspecialchars($pet['Alergias']) ?>">
      </div>

      <div class="col-12 m-1">
        <label for="numeroSerie" id="label-numeroSerie">Número de série:</label>
        <input type="text" name="numeroSerie" id="numeroSerie" class="border-left-0 border-right-0 border-top-0 border ml-2 p-1" value="<?= htmlspecialchars($pet['Identificacao']) ?>">
      </div>

      <div>
        <?php
        $foto = $pet['Foto'] ?? '';
        $pathFoto = '../registre-seu-pet/pets/' . $foto;
        $src = (file_exists($pathFoto) && !empty($foto)) ? $pathFoto : '../img/img-exemplo.png';
        ?>
        <img src="<?= $src ?>" id="preview" alt="Foto do pet">
        <div class="custom-file-upload">
          <label for="inputImagem" id="label-foto" class="btn label">Trocar imagem:</label>
          <input name="inputImagem" id="inputImagem" type="file" accept="image/png, image/jpeg" style="display: none;">
        </div>
      </div>
    </fieldset>

    <input type="submit" id="submit" value="Salvar alterações" class="btn col-12 mt-3 submitBtn" style="background-color: #5beeba; color: white;">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <script src="./editar-seu-pet.js"></script>
  <script src="./validacao.js"></script>
</body>
</html>
