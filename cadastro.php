<?php
// faz a conexao com o banco
include_once "connection.php";

// variaveis
$msg = '';

if(isset($_POST)){
    $id = 7;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $birthDate = explode('/',$_POST['birthDate']);
    $birthDate = $birthDate[2].'-'.$birthDate[1].'-'.$birthDate[0];
    $password = '123456abcNacional';
    $whatsapp = $_POST['whatsapp'];

    $select1 = "SELECT * FROM `pessoas` WHERE Email = '$email'";
    $selectUser = mysqli_query($conn, $select1);

    if(mysqli_num_rows($selectUser) > 0){
        $msg = 'E-mail já cadastrado';
    }else{
        $insert1 = "INSERT INTO `pessoas`(`Nome`, `Cidade`, `Email`, `DataNascimento`, `Whatsapp`, `Senha`, `Excluido`) VALUES ('$name','$city','$email','$birthDate','$whatsapp','$password',0)";  
        mysqli_query($conn, $insert1);        
    }
    header("Location: register.php");
}
?>