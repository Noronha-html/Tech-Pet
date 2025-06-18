<?php
//Conexão com o banco
session_start();
include_once "../conexao.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$loginErro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Captura os dados enviados pelo formulário
    $email   = trim($_POST['username'] ?? '');
    $senha   = $_POST['password'] ?? '';

    //Validações básicas de preenchimento
    if ($email === "" || $senha === "") {
        $loginErro = "Por favor, informe usuário (e-mail) e senha.";
    } else {
        //Procura o usuário no banco pelo e-mail
        $sql = "SELECT PessoaID, Senha FROM pessoas WHERE Email = ? AND Excluido = 0 LIMIT 1";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $loginErro = "Erro interno. Tente novamente mais tarde.";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 0) {
                //Não encontrou nenhum usuário com esse e-mail
                $loginErro = "Usuário ou senha incorretos.";
            } else {
                $row = $res->fetch_assoc();
                $hashNoBanco = $row['Senha'];
                $usuarioId   = $row['PessoaID'];

                //Verifica a senha
                if (password_verify($senha, $hashNoBanco)) {
                    //Login bem-sucedido: define a sessão e redireciona
                    $_SESSION['usuario_id'] = $usuarioId;
                    header("Location: ../conta-usuario/conta-usuario.php");
                    exit;
                } else {
                    $loginErro = "Usuário ou senha incorretos.";
                }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit=no">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <title>TechPet - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../logar/logar.css">
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100" style="background-color: rgb(234, 224, 224);">

    <?php if (!empty($loginErro)): ?>
      <div class="alert alert-danger w-25 text-center" style="margin-left: 24.55%; transform: translateX(-50%);" role="alert">
          <i class="fa-solid fa-triangle-exclamation"></i> 
          <strong>Atenção!</strong>
        <?= htmlspecialchars($loginErro) ?>
      </div>
    <?php endif; ?>

    <form action="" method="post" id="formLogin" class="row d-flex justify-content-center align-items-center bg-white shadow-sm p-4 box" style="border-radius: 1rem; max-width: 300px;">
        <div class="d-flex justify-content-end col-12 p-0">
            <a aria-label="Fechar" href="../lobby/index.html" class="border-0" style="color: black;">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </a>
        </div>
        <div class="d-flex col-12 justify-content-start">
            <h2 style="color:#5beeba;" aria-describedby="Login">Login</h2>
        </div>
        <div class="d-flex col-12 flex-column justify-content-start mt-2">
            <label for="username" class="mt1-1" aria-label="Usuário" id="label-user">Email</label>
            <input
              type="text"
              id="username"
              name="username"
              required
              aria-placeholder="Digite seu Email"
              placeholder="Digite seu Email"
              class="p-2 rounded border-top-0 border-left-0 border-right-0 border-bottom"
              value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
            >
        </div>
        <div class="d-flex col-12 flex-column justify-content-start mt-2">
            <label for="password" id="label-password" class="mt-1" aria-label="Senha">Senha</label>
            <input
              type="password"
              id="password"
              name="password"
              required
              aria-placeholder="Digite sua senha"
              placeholder="Digite sua senha"
              class="p-2 rounded border-top-0 border-left-0 border-right-0 border-bottom"
            >
        </div>
        <div class="d-flex col-12 justify-content-end">
            <input type="checkbox" id="password-checkbox" class="mr-1 checkbox-container" aria-checked="false" style="cursor: pointer;">
            <label for="password-checkbox" class="mt-2" aria-label="Exibir senha">Exibir senha</label>
        </div>

         <input type="submit" class="col-12 border-0 btn" id="buttonEntrar" value="Entrar" style="background-color: #5beeba; color: white;">

        <div class="d-flex flex-column align-items-center col-12 mt-3">
            <p aria-label="Não possui uma conta?">Não possui uma conta?</p>
            <a href="../registre-se/registre-se.php" aria-describedby="Criar Nova Conta">Criar Nova Conta</a>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" 
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" 
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../logar/logar.js"></script>
</body>
</html>
