<?php
//Conexão com o banco
session_start();
include_once "../conn.php";

//Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id']) || !filter_var($_SESSION['usuario_id'], FILTER_VALIDATE_INT)) {
    header("Location: ../login.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];

//Pega todos os pets do usuário
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
    <div class="mb-4 text-right">
      <a href="../editar-usuario/editar-usuario.php" style="position: absolute; top: 2rem; right: 5%; color: white; font-size: 1.2rem; text-decoration: none; border-radius: 1rem; padding: 0.5rem 1rem; background-color: #5beeba; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        Editar Perfil
      </a>
    </div>
<a aria-label="Fechar"
   href="../lobby/index.html"
   class="text-white"
   style="
     position: absolute;
     top: 2rem;            /* ajuste vertical */
     right: 1%;           /* ajuste horizontal */
     font-size: 1.5rem;    /* tamanho do ícone */
     background-color: #5beeba; /* cor de fundo válida */
      border-radius: 10%;
      min-width: 40px;
      text-align: center;
      
   ">
  <i class="fa-solid fa-xmark"></i>
</a>
    <?php if (count($listaPets) === 0): ?>
      <div class="alert alert-info">
        Você ainda não cadastrou nenhum pet. <a href="registre-seu-pet.php" class="alert-link">Cadastre agora</a>.
      </div>
    <?php else: ?>
      <div class="row">
        <?php foreach ($listaPets as $pet): ?>
          <div class="col-md-4">
            <div class="card pet-card shadow d-flex flex-row" style=" min-width: 350px; min-height: 400px; max-height:400px; border-radius: 1rem;">
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
                  <strong>Peso:</strong> <?= htmlspecialchars($pet['Peso']) ?> kg<br>
                  <strong>Nascimento:</strong> <?= date("d/m/Y", strtotime($pet['DataNascimento'])) ?>
                  <strong>Alergias:</strong> <?= htmlspecialchars($pet['Alergias']) ?><br>
                  <strong>Vacinas:</strong> <?= htmlspecialchars($pet['Vacinas']) ?><br>
                </p>
                <a href="../editar-seu-pet/editar-seu-pet.php?id=<?= urlencode($pet['PetID']) ?>" class="btn btn-sm mt-2" style="background-color: #5beeba; color: white; font-size: 1.2rem; border-radius: 1rem;">
                  Editar
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <button type="button" class="novoCadastro" style="width: 30%; min-width: 80px; height: 70px; min-height: 70px; border-radius: 1rem; position: relative; left: 35%;
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

          <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>
</body>
</html>
