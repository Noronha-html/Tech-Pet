<?php
session_start();
include_once "../conexao.php";    // ajuste este caminho se necessário
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1) Se o usuário já estiver logado, redirecione direto para a conta de pets
/*if (isset($_SESSION['usuario_id'])) {
    header("Location: ../conta-usuario/conta-usuario.php");
    exit;
}*/

// 2) Só aceita requisição via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ./registre-se.php");
    exit;
}

// 3) Recebe os campos do formulário (nome, e-mail, senha e confirmação)
$nome            = trim($_POST['name'] ?? '');
$email           = trim($_POST['email'] ?? '');
$senha           = $_POST['senhaRegistro'] ?? '';
$confirmarSenha  = $_POST['confirmarSenhaRegistro'] ?? '';

$errors = [];

// 4) Validações básicas

// 4.1) Nome
if ($nome === '') {
    $errors[] = "O campo Nome é obrigatório.";
} elseif (mb_strlen($nome) < 3) {
    $errors[] = "O Nome deve ter ao menos 3 caracteres.";
}

// 4.2) E-mail
if ($email === '') {
    $errors[] = "O campo E-mail é obrigatório.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Digite um e-mail válido.";
} else {
    // checa se já existe alguém cadastrado com esse e-mail
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

// 4.3) Senha e confirmação
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

// 5) Se houver erros, salva em sessão e redireciona para registro novamente
if (!empty($errors)) {
    // guarda mensagens de erro
    $_SESSION['registro_erros'] = $errors;
    // guarda valores antigos para “sticky form” (opcional)
    $_SESSION['registro_old'] = [
        'nome'  => $nome,
        'email' => $email
    ];
    header("Location: ./registre-se.php");
    exit;
}

// 6) Se tudo ok, insere o novo usuário no banco
$hashSenha = password_hash($senha, PASSWORD_DEFAULT);
$sqlIns = "INSERT INTO pessoas (Nome, Email, Senha, Excluido) VALUES (?, ?, ?, 0)";
$stmtIns = $conn->prepare($sqlIns);
$stmtIns->bind_param("sss", $nome, $email, $hashSenha);

if (!$stmtIns->execute()) {
    // se deu erro no INSERT, registra no log e redireciona com mensagem genérica
    error_log("Falha ao cadastrar usuário: " . $stmtIns->error);
    $_SESSION['registro_erros'] = ["Ocorreu um erro ao processar seu cadastro. Tente novamente mais tarde."];
    header("Location: ./registre-se.php");
    exit;
}

$novoUsuarioId = $stmtIns->insert_id;
$stmtIns->close();

// 7) Define a sessão como logada
$_SESSION['usuario_id'] = $novoUsuarioId;

// 8) Redireciona para a área do usuário (listagem de pets)
header("Location: ../registre-seu-pet/registre-seu-pet.php");
exit;
