<?php
session_start();
include_once "../conexao.php";    // ajuste este caminho se necessário
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1) Só aceita requisição via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ./registre-se.php");
    exit;
}

// 2) Recebe os campos do formulário (nome, e-mail, senha, confirmação, estado, cidade, wpp)
$nome            = trim($_POST['name']                  ?? '');
$email           = trim($_POST['email']                 ?? '');
$senha           = $_POST['senhaRegistro']              ?? '';
$confirmarSenha  = $_POST['confirmarSenhaRegistro']     ?? '';
$estadoSelecionado  = trim($_POST['estados']            ?? '');
$cidadeSelecionada  = trim($_POST['cidades']            ?? '');
$data_nascimento          = trim($_POST['dtnasc']               ?? '');
$wpp             = trim($_POST['wpp']                   ?? '');

$errors = [];

// 3) Validações básicas (Nome, Email, Senha — já existentes no seu código)

// 3.1) Nome
if ($nome === '') {
    $errors[] = "O campo Nome é obrigatório.";
} elseif (mb_strlen($nome) < 3) {
    $errors[] = "O Nome deve ter ao menos 3 caracteres.";
}

// 3.2) E-mail
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

// 3.3) Senha e confirmação
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

// 3.4) Estado (novo)
if ($estadoSelecionado === '') {
    $errors[] = "Selecione um Estado.";
}

// 3.5) Cidade (novo)
if ($cidadeSelecionada === '') {
    $errors[] = "Selecione uma Cidade.";
}

if($data_nascimento === '') {
    $errors[] = "O campo Data de Nascimento é obrigatório.";
} else {
    $dataNascimento = $data_nascimento; // Se for obrigatório, use a data validada abaixo

}

// 3.6) Número de celular (wpp) (novo)
if ($wpp === '') {
    $errors[] = "O campo Número de celular é obrigatório.";
} elseif (!preg_match('/^\d{10,11}$/', preg_replace('/\D/', '', $wpp))) {
    $errors[] = "Digite um número de celular válido (apenas dígitos).";
}

// 4) Se houver erros, salva em sessão e redireciona para registro novamente
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

// 5) Se tudo ok, insere o novo usuário no banco, incluindo Estado, Cidade e Celular/Whatsapp

$hashSenha = password_hash($senha, PASSWORD_DEFAULT);

// • Verifique o nome exato das colunas na sua tabela `pessoas`: 
//   vou assumir aqui que elas se chamam `Estado`, `Cidade` e `Whatsapp`.
//   Se no seu BD o campo de celular se chamar `Celular`, troque `Whatsapp` por `Celular`.

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
    // Se der erro no INSERT, registra no log e volta com mensagem genérica
    error_log("Falha ao cadastrar usuário: " . $stmtIns->error);
    $_SESSION['registro_erros'] = [
        "Ocorreu um erro ao processar seu cadastro. Tente novamente mais tarde."
    ];
    header("Location: ./registre-se.php");
    exit;
}

$novoUsuarioId = $stmtIns->insert_id;
$stmtIns->close();

// 6) Define a sessão como logada
$_SESSION['usuario_id'] = $novoUsuarioId;

// 7) Redireciona para a próxima etapa (cadastro de pet)
header("Location: ../registre-seu-pet/registre-seu-pet.php");
exit;
?>
