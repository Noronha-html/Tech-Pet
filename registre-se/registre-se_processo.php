<?php
session_start();
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
        }

        if (!validarSenha()) {
            exit("Senha inválida. Por favor, use apenas letras e espaços.");
        }

        if(!confirmarSenha()) {
            exit("As senhas não coincidem. Por favor, tente novamente.");
        }

        if(!validarEstadoCidade()) {
            exit("Por favor, selecione um estado e uma cidade.");
        }

        if(!validarEmail()) {
            exit("E-mail inválido. Por favor, insira um e-mail válido.");
        }

        if(!validarDataNascimento()) {
            exit("Data de nascimento inválida. Por favor, insira uma data válida.");
        }

        if(!validarTelefone()) {
            exit("Número de telefone inválido. Por favor, insira um número válido.");
        }

        if(validarNome() && validarSenha() && confirmarSenha() && validarEstadoCidade() && validarEmail() && validarDataNascimento() && validarTelefone()) {
            // Insere os dados no banco de dados
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

function validarSenha() {
    if (isset($_POST['senhaRegistro']) && !empty($_POST['senhaRegistro'])) {
        $password = $_POST['senhaRegistro'];
        return true;
    }
    return false;
}

function confirmarSenha() {
    if (isset($_POST['confirmarSenhaRegistro']) && !empty($_POST['confirmarSenhaRegistro'])) {
        $confirmPassword = $_POST['confirmarSenhaRegistro'];
        if(isset($_POST['senhaRegistro']) && $_POST['senhaRegistro'] === $confirmPassword) {
            return true;
        }
    }
    return false;
}

function validarEstadoCidade() {
    if (isset($_POST['estados']) && !empty($_POST['estados']) && isset($_POST['cidades']) && !empty($_POST['cidades'])) {
        $state = $_POST['estados'];
        $city = $_POST['cidades'];
        return true;
    }
    return false;
}

function validarEmail() {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
    }
    return false;
}

function validarDataNascimento() {
    if (isset($_POST['dtnasc']) && !empty($_POST['dtnasc'])) {
        $birthDate = $_POST['dtnasc'];
        $date = DateTime::createFromFormat('Y-m-d', $birthDate);
        if ($date && $date->format('Y-m-d') === $birthDate) {
            return true;
        }
    }
    return false;
}

function validarTelefone() {
    if (isset($_POST['wpp']) && !empty($_POST['wpp'])) {
        $whatsapp = $_POST['wpp'];
        // Verifica se o número de telefone contém apenas dígitos e tem entre 10 e 11 dígitos
        //if (preg_match('/^\d{10,11}$/', $whatsapp)) {
            return true;
        //}
    }
    return false;
}
?>