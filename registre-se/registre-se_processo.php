<?php
//Conexão com o banco
session_start();
include_once "../conexao.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Só aceita requisição via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ./registre-se.php");
    exit;
}

//Recebe os campos do formulário
$nome            = trim($_POST['name']                  ?? '');
$email           = trim($_POST['email']                 ?? '');
$senha           = $_POST['senhaRegistro']              ?? '';
$confirmarSenha  = $_POST['confirmarSenhaRegistro']     ?? '';
$estadoSelecionado  = trim($_POST['estados']            ?? '');
$cidadeSelecionada  = trim($_POST['cidades']            ?? '');
$data_nascimento          = trim($_POST['dtnasc']               ?? '');
$wpp             = trim($_POST['wpp']                   ?? '');

$errors = [];

//Validações básicas

//Validação Nome
if ($nome === '') {
    $errors[] = "O campo Nome é obrigatório.";
} elseif (mb_strlen($nome) < 3) {
    $errors[] = "O Nome deve ter ao menos 3 caracteres.";
}

//Validação E-mail
if ($email === '') {
    $errors[] = "O campo E-mail é obrigatório.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Digite um e-mail válido.";
} else {
    $sqlVerEmail = "SELECT 1 FROM pessoas WHERE Email = ? AND Excluido = 0";
    $stmtVerEm = $conn->prepare($sqlVerEmail);
    $stmtVerEm->bind_param("s", $email);
    $stmtVerEm->execute();
    $resEm = $stmtVerEm->get_result();
    if ($resEm->num_rows > 0) {
        $errors[] = "Já existe uma conta com este e-mail.";
    }
    $stmtVerEm->close();
}

//Validação Senha e confirmação
if ($senha === '') {
    $errors[] = "O campo Senha é obrigatório.";
} elseif (mb_strlen($senha) < 6) {
    $errors[] = "A Senha deve ter ao menos 6 caracteres.";
}
if ($confirmarSenha === '') {
    $errors[] = "Por favor, confirme a senha.";
} elseif ($senha !== $confirmarSenha) {
    $errors[] = "As senhas não coincidem.";
}

//Validação Estado
if ($estadoSelecionado === '') {
    $errors[] = "Selecione um Estado.";
}

//Validação Cidade
if ($cidadeSelecionada === '') {
    $errors[] = "Selecione uma Cidade.";
}

if($data_nascimento === '') {
    $errors[] = "O campo Data de Nascimento é obrigatório.";
} else {
    $dataNascimento = $data_nascimento;

}

//Número de celular
if ($wpp === '') {
    $errors[] = "O campo Número de celular é obrigatório.";
} elseif (!preg_match('/^\d{10,11}$/', preg_replace('/\D/', '', $wpp))) {
    $errors[] = "Digite um número de celular válido (apenas dígitos).";
}

//Se houver erros, salva em sessão e redireciona para registro novamente
if (!empty($errors)) {
    $_SESSION['registro_erros'] = $errors;
    $_SESSION['registro_old'] = [
        'name'    => $nome,
        'email'   => $email,
        'estados' => $estadoSelecionado,
        'cidades' => $cidadeSelecionada,
        'dtnasc'  => $dataNascimento,
        'wpp'     => $wpp
    ];
    header("Location: ./registre-se.php");
    exit;
}

//Se tudo ok, insere o novo usuário no banco

$hashSenha = password_hash($senha, PASSWORD_DEFAULT);

$sqlIns = " INSERT INTO pessoas 
        (Nome, Email, Senha, Estado, Cidade, DataNascimento, Whatsapp, Excluido) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 0)
";
$stmtIns = $conn->prepare($sqlIns);
$stmtIns->bind_param(
    "sssssss",
    $nome,
    $email,
    $hashSenha,
    $estadoSelecionado,
    $cidadeSelecionada,
    $dataNascimento,
    $wpp
);

if (!$stmtIns->execute()) {
    // Se der erro no INSERT, registra no log
    error_log("Falha ao cadastrar usuário: " . $stmtIns->error);
    $_SESSION['registro_erros'] = [
        "Ocorreu um erro ao processar seu cadastro. Tente novamente mais tarde."
    ];
    header("Location: ./registre-se.php");
    exit;
}

$novoUsuarioId = $stmtIns->insert_id;
$stmtIns->close();

//Define a sessão como logada
$_SESSION['usuario_id'] = $novoUsuarioId;

//Redireciona para o cadastro do pet
header("Location: ../registre-seu-pet/registre-seu-pet.php");
exit;
?>
