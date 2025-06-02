<?php
// faz a conexao com o banco
include_once "../conexao.php";

// variaveis
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (mysqli_num_rows($selectUser) > 0) {
        $msg = 'E-mail já cadastrado';
        echo $msg;
        exit;
    } else {
        if (!validarNome()) {
            exit("Nome inválido. Por favor, use apenas letras e espaços.");
        } else {
            $insert1 = "INSERT INTO `pessoas`(`Nome`, `Estado`, `Cidade`, `Email`, `DataNascimento`, `Whatsapp`, `Senha`, `Excluido`) VALUES ('$name','$state','$city','$email','$birthDate','$whatsapp','$password',0)";  
            $result = mysqli_query($conn, $insert1);

            if ($result) {
                $id = mysqli_insert_id($conn);
                header("Location: ../registre-seu-pet/registre-seu-pet.php?registro=" . $id);
                exit;
            } else {
                echo "Erro ao inserir: " . mysqli_error($conn);
                exit;
            }
        }
    }
}

function validarNome() {
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = $_POST['name'];
        if (preg_match('/^[a-zA-Z\s]+$/', $name)) {
            return true;
        }
    }
    return false;
}

?>