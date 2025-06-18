<?php
$atualizador = 't='.base64_encode(date('YmdHis').rand(0, 9999));

session_start();

//Recupera erros e valores antigos, se existirem
$petErrors = $_SESSION['pet_errors'] ?? [];
$petOld    = $_SESSION['pet_old']    ?? [];

//Limpa para não reaparecer após refresh
unset($_SESSION['pet_errors'], $_SESSION['pet_old']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TechPet - Registrar Pet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../registre-seu-pet/registre-seu-pet.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="container-fluid d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <?php if (!empty($petErrors)): ?>
    <div class="alert alert-danger w-25">
        <ul class="mb-0">
        <?php foreach ($petErrors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <form id="formRegistraPet" enctype="multipart/form-data" action="./registre-seu-pet_processo.php" method="post" class="d-flex row flex-column align-items-center shadow p-4 m-5" style="border-radius: 1rem;">
                  <div class="d-flex justify-content-end col-12 p-0">
      <a aria-label="Fechar" href="../lobby/index.html" class="border-0 text-dark">
        <i class="fa-solid fa-xmark fa-xl"></i>
      </a>
    </div>
        <legend class="col-12">Registre seu Pet</legend>
        <input type="hidden" name="registro" id="registro" value="<?php echo isset($_GET['registro']) ? $_GET['registro'] : ''; ?>">
        <fieldset class="border p-3" style="border-radius: 1rem;">
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="name" id="label-name">Nome: </label>
                <input type="text" name="name" id="name" class="border-left-0 border-right-0 border-top-0 border ml-2 mr-2  p-1" placeholder="Digite o nome do seu pet">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="dtnasc" id="label-dtnasc">Data de nascimento: </label>
                <input type="date" name="dtnasc" id="dtnasc" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="peso" id="label-peso">Peso: </label>
                <input type="text" name="peso" id="peso" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite o peso do seu pet">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="vacinas" id="label-vacinas">Vacinas: </label>
                <input type="text" name="vacinas" id="vacinas" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite as vacinas do seu pet">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="alergias" id="label-alergias">Alergias:</label>
                <input type="text" name="alergias" id="alergias" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite as alergias do seu pet">
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="numeroSerie" id="label-numeroSerie">número de série:</label>
                <input type="tel" name="numeroSerie" id="numeroSerie" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite o número de série">
            </div>  
            <div>
                <img src="../img/img-exemplo.png" id="preview" alt="">
                <div class="custom-file-upload">
                    <label for="inputImagem" id="label-foto" class="btn label">Escolher imagem:</label>
                    <input name="inputImagem" id="inputImagem" type="file" accept="image/png, image/jpeg" style="display: none;">
                </div>
            </div>
        </fieldset>
        
        <input type="submit" id="submit" value="Enviar" class="btn col-12 mt-3 submitBtn" style="background-color: #5beeba; color: white;">

    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj " crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../registre-seu-pet/registre-seu-pet.js"></script>
    <script src="../registre-seu-pet/validacao.js"></script>
</body>
</html>