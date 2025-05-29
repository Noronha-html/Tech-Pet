<?php
$atualizador = 't='.base64_encode(date('YmdHis').rand(0, 9999));
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" , shrink-to-fit=no">
    <title>TechPet - pet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../pet/pet.css?<?pho echo $atualizador;?>">
    <link rel="shortcut icon" href="../Tech-Pet/img/logo.png" type="image/x-icon">
</head>

<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <form action="" method="post" class="d-flex row w-auto flex-column align-items-center shadow p-4 m-4"
        style="border-radius: 1rem;">
        <fieldset class=" col-11 border p-3 mt-2" style="border-radius: 1rem;">
            <div class="col-12 justify-content-start align-items-start">
                <p id="usuario-nome"></p>
                <p id="usuario-email"></p>
                <p id="pet-nome"></p>
                <p id="pet-nascimento"></p>
                <p id="pet-peso"></p>
                <p id="pet-vacinas"></p>
                <p id="pet-alergias"></p>
                <img id="pet-imagem" src="" alt="Imagem do Pet">
            </div>


        </fieldset>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj "
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../pet/pet.js?<?pho echo $atualizador?>"></script>
</body>

</html>