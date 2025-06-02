<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TechPet - Registrar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../registre-se/registre-se.css">
    <link rel="shortcut icon" href="../img/Image.jfif.png" type="image/x-icon">
</head>
<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <form id="formRegistreSe" action="registre-se_processo.php" method="post" class="d-flex row h-auto w-auto flex-column align-items-center shadow p-4 m-5" style="border-radius: 1rem;">
        <legend class="col-11 h6" >Informações para Cadastro</legend>
        <fieldset class=" col-11 h-auto w-auto border p-3" style="border-radius: 1rem;">
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="name" id="label-name" class="mt-2">Nome: </label>
                <input type="text" name="name" id="name" aria-placeholder="Digite o seu nome completo" class="border-left-0 border-right-0 border-top-0 border ml-2 mr-2  p-1" placeholder="Digite o seu nome completo">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="senhaRegistro" id="label-senha" class="mt-2">Senha: </label>
                <div class=" col-11 border-left-0 border-right-0 border-top-0 border ml-2 d-flex p-1">
                    <input type="password" name="senhaRegistro" id="senhaRegistro" aria-placeholder="Crie uma senha" class="border-0" placeholder="Crie uma senha">
                    <i class="fa-solid fa-eye-slash fa-sm icon-input" id="icon-input-senha"></i>
                </div>
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="confirmarSenhaRegistro" id="label-confirmarSenha" class="mt-2">Confirmar Senha: </label>
                <div class=" col-11 border-left-0 border-right-0 border-top-0 border ml-2 d-flex p-1">
                    <input type="password" name="confirmarSenhaRegistro" id="confirmarSenhaRegistro" aria-placeholder="Confirme a mesma senha" class="border-0" placeholder="Confirme a mesma senha">
                    <i class="fa-solid fa-eye-slash fa-sm icon-input" id="icon-input-confirmar-senha"></i>
                </div>
                </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="estados" id="label-estado" class="mt-2">Estado: </label>
                <select name="estados" id="estados" aria-label="Selecione o seu estado" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1"></select>
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="cidades" id="label-cidade" class="mt-2">Cidade: </label>
                <select name="cidades" id="cidades" aria-placeholder="Selecione a sua cidade" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" style="width: 170px;"></select>
            </div>
        
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="email" id="label-email" class="mt-2">Email: </label>
                <input type="email" name="email" id="email" aria-placeholder="Digite o seu email" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite o seu email">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="dtnasc" id="label-dtnasc">Data de nascimento: </label>
                <input type="date" name="dtnasc" id="dtnasc" aria-placeholder="Digite a sua data de nascimento" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite a sua Data de nascimento">
            </div>
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="wpp" id="label-wpp" class="mt-2">Número de celular:</label>
                <input type="tel" name="wpp" id="wpp" aria-placeholder="Digite o seu número" class="border-left-0 border-right-0 border-top-0 border ml-2  p-1" placeholder="Digite o seu número">
            </div>
        </fieldset>
        <button type="button" id="enviar" class="btn col-11 mt-3 submit" style="background-color: #5beeba; color: white;">Enviar</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj " crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../registre-se/registre-se.js"></script>
    <script src="../registre-se/validacao.js"></script>
</body>
</html>