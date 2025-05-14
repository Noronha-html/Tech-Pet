<?php
    include("connection.php");

    $msg = '';

    if(isset($_POST['submit']))
    {
        $id = 7;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $birthDate = $_POST['birthDate'];
        $whatsapp = $_POST['whatsapp'];

        $select1 = "SELECT * FROM `pessoas` WHERE Email = '$email'";
        $selectUser = mysqli_query($conn, $select1);

        if(mysqli_num_rows($selectUser) > 0)
        {
            $msg = 'Email ja cadastrado';
        }
        else
        {
            $insert1 = "INSERT INTO `pessoas`(`PessoaID`, `Nome`, `Cidade`, `Email`, `DataNascimento`, `Whatsapp`, `Senha`, `Excluido`) VALUES ('$id','$name','$city','$email','$birthDate','$whatsapp','[value-7]','[value-8]')";
            mysqli_query($conn, $insert1);
            //$msg = 'Cadastro realizado com sucesso';
            //$insert = "INSERT INTO `pessoas`(`PessoaID`, `Nome`, `Cidade`, `Email`, `DataNascimento`, `Whatsapp`) VALUES (NULL,'$name', '$city', '$email', '$birthDate', '$whatsapp')";
            //$insertUser = mysqli_query($conn, $insert);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>TechPet</title>
</head>
<body>
    <form action="" class="container">
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
 
                <button class="submit" type="button" name="submit">Enviar</button>
 
            </div>
        </div>
    </form>
 
    <!--script src="../registre-se/registre-se.js"></script-->
</body>
</html>