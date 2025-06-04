<?php
session_start();
include_once "../conexao.php";

// 1) Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id']) || !filter_var($_SESSION['usuario_id'], FILTER_VALIDATE_INT)) {
    // redireciona para login ou dá erro 401
    header("Location: ../login.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];

// 2) Prepara e executa query que traz todos os pets deste usuário
$sql = " SELECT 
        p.PetID,
        p.Identificacao,
        p.Nome,
        p.Peso,
        p.DataNascimento,
        p.Especie,
        p.Foto,
        p.Alergias,
        p.Vacinas
    FROM pets AS p
    INNER JOIN pessoapet AS pp ON p.PetID = pp.PetID
    WHERE pp.PessoaID = ?
      AND p.Excluido = 0
      AND pp.Excluido = 0
    ORDER BY p.Nome ASC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();
$listaPets = [];
while ($row = $result->fetch_assoc()) {
    $listaPets[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Minha Conta – Meus Pets</title>
    <!-- Links CSS, Bootstrap etc. -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
      .pet-card { margin-bottom: 1.5rem; }
      .pet-card img { width: 100%; height: auto; object-fit: cover; }
      .pet-card h5 { margin-top: 0.5rem; }
    </style>
</head>
<body style="background-color: rgb(234, 224, 224);">
  <div class="container mt-4" style="padding-bottom: 2rem;">
    <h1 class="mb-4">Seus Pets Cadastrados</h1>

    <?php if (count($listaPets) === 0): ?>
      <div class="alert alert-info">
        Você ainda não cadastrou nenhum pet. <a href="registre-seu-pet.php" class="alert-link">Cadastre agora</a>.
      </div>
    <?php else: ?>
      <div class="row">
        <?php foreach ($listaPets as $pet): ?>
          <div class="col-md-4">
            <div class="card pet-card shadow d-flex flex-row" style="min-height: 280px; border-radius: 1rem;">
              <?php $imgPath = __DIR__ . '/../registre-seu-pet/pets/' . $pet['Foto'];
                    if (!empty($pet['Foto']) && file_exists($imgPath)): ?>
                        <img style="width: 40%; border-radius: 1rem;" src="../registre-seu-pet/pets/<?= htmlspecialchars($pet['Foto']) ?>"
                        alt="Foto de <?= htmlspecialchars($pet['Nome']) ?>">
              <?php else: ?>
                <img src="https://via.placeholder.com/350x200?text=Sem+Foto" 
                     class="card-img-top" 
                     alt="Sem Foto" />
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title" style="color: #5beeba; font-size: 1.5rem"><?= htmlspecialchars($pet['Nome']) ?></h5>
                <p class="card-text">
                  <strong>Identificação:</strong> <?= htmlspecialchars($pet['Identificacao']) ?><br>
                  <strong>Espécie:</strong> <?= htmlspecialchars($pet['Especie']) ?><br>
                  <strong>Peso:</strong> <?= htmlspecialchars($pet['Peso']) ?> kg<br>
                  <strong>Nascimento:</strong> <?= date("d/m/Y", strtotime($pet['DataNascimento'])) ?>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <button type="button" class="novoCadastro" style="width: 30%; height: 50px; position: relative; left: 35%;
    border: none; background-color: #5beeba; color: white; font-size: 1.3rem;">Cadastrar outro pet</button>
  </div>

  <!-- JS do Bootstrap e jQuery -->
   <script src="./conta-usuario.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" 
          integrity="sha384-ZvpUoO/+Pv3IPm49EF+5GcgLit/smW1xSYJkGxWAwHgtlU3hq8CV3w1uU8Fg5/WN" 
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" 
          crossorigin="anonymous"></script>
</body>
</html>
