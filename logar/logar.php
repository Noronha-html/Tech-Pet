<?php
$atualizador = 't='.base64_encode(date('YmdHis').rand(0, 9999));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit=no">
    <link rel="shortcut icon" href="../img/Image.jfif.png" type="image/x-icon">
    <title>TechPet - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../logar/logar.css?<?pho echo $atualizador;?>">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <form action="" method="post" class="row d-flex flex-column justify-content-center align-items-center bg-white shadow-sm p-4 box" style="border-radius: 1rem;">
        <div class="d-flex justify-content-end col-12 p-0">
            <a aria-label="Fechar" href="../lobby/index.html" class="border-0 " style="color: black;">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </a>
        </div>
        <div class="d-flex col-12 justify-content-start">
            <h2 style="color:#5beeba;" aria-describedby="Login">Login</h2>
        </div>
        <div class="d-flex col-12 flex-column justify-content-start mt-2">
            <label for="username" class="mt1-1" aria-label="Usuário" id="label-user">Usuário</label>
            <input type="text" id="username" name="username" required aria-placeholder="Digite seu usuário" placeholder="Digite seu usuário" class="p-2 rounded border-top-0 border-left-0 border-right-0 border-bottom">
        </div>
 
        <div class="d-flex col-12 flex-column justify-content-start mt-2">
            <label for="password" id="label-password" class="mt-1" aria-label="Senha">Senha</label>
            <input type="password" id="password" name="password" required aria-placeholder="Digite sua senha" placeholder="Digite sua senha" class="p-2 rounded border-top-0 border-left-0 border-right-0 border-bottom">
        </div>
        <div class="d-flex col-12 justify-content-end">
            <input type="checkbox" id="password-checkbox" class="mr-1 checkbox-container" aria-checked="false" style="cursor: pointer; ">
            <label for="password-checkbox" class="mt-2" aria-label="Exibir senha">Exibir senha</label>
        </div>

         <input type="submit" class="col-12 border-0 btn" id="buttonEntrar" value="Entrar" style="background-color: #5beeba; color: white;">
        
        <!--a src="../conta-usuario/conta-usuario.html" id="buttonEntrar" class="btn mt-2 border-0 col-10">
            <button type="submit"class="col-12 border-0 btn" id="buttonEntrar" style="background-color: #5beeba; color: white;">Entrar</button>
        </a-->
        
        <div class="d-flex flex-column align-items-center col-12 mt-3">
            <p aria-label="Não possui uma conta?">Não possui uma conta?</p>
            <a href="../registre-se/registre-se.html" aria-describedby="Criar Nova Conta">Criar Nova Conta</a>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj " crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../logar/logar.js?<?pho echo $atualizador;?>"></script>
</body>
</html>
