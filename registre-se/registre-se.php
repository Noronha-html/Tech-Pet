<?php
// faz a conexao com o banco
include_once "../conexao.php";
 
// variaveis
$msg = '';
if(isset($_POST)){
    $id = 7;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $state = $_POST['estados'];
    $city = $_POST['cidades'];
    $birthDate = $_POST['dtnasc'];
    $password = $_POST['senhaRegistro'];
    $whatsapp = $_POST['wpp'];
 
    $select1 = "SELECT * FROM `pessoas` WHERE Email = '$email' AND Senha = '$password'";
    $selectUser = mysqli_query($conn, $select1);
 
    if(mysqli_num_rows($selectUser) > 0){
        $msg = 'E-mail já cadastrado';
    }else{
        $insert1 = "INSERT INTO `pessoas`(`Nome`, `Estado`, `Cidade`, `Email`, `DataNascimento`, `Whatsapp`, `Senha`, `Excluido`) VALUES ('$name','$state','$city','$email','$birthDate','$whatsapp','$password',0)";  
        mysqli_query($conn, $insert1);        
        $id = mysqli_insert_id($conn);
    }
    header("Location: ../registre-seu-pet/registre-seu-pet.php?registro=".$id);
}
?>
 