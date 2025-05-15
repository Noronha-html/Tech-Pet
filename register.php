<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>TechPet</title>
</head>
<body>
    <form action="./cadastro.php" method="post" class="container">
        <h1 class="title">registre-se aqui!</h1>
        <p class="msg"><? = $msg ?></p>
            <div class="divInputs">
                <label for="" class="label">Nome:</label>
                <input type="text" name="name" id="name" class="input" placeholder="Digite o seu nome">
   
                <label for="" class="label">Cidade:</label>
                <input type="text" name="city" id="age" class="input" placeholder="Digite a sua Cidade">
   
                <label for="" class="label">Email:</label>
                <input type="text" name="email" id="weight" class="input" placeholder="Digite o Email">
   
                <label for="" class="label">Data de nacimento</label>
                <input type="text" name="birthDate" id="alergies" class="input" placeholder="Digite a sua Data de nascimento">
 
                <label for="" class="label">whatsapp:</label>
                <input type="text" name="whatsapp" id="alergies" class="input" placeholder="Digite o seu whatsapp">
 
                <input class="submit" type="submit" name="submit">Enviar</input>
 
            </div>
        </div>
    </form>
 
    <!--script src="../registre-se/registre-se.js"></script-->
</body>
</html>