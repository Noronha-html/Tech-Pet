<?php
session_start();

// Se o usuário já estiver logado, redireciona para a área de pets
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../conta-usuario/conta-usuario.php");
    exit;
}

// Recupera mensagens de erro e valores antigos (sticky form), se existirem
$errors = $_SESSION['registro_erros'] ?? [];
$old    = $_SESSION['registro_old']   ?? [];

// Limpa variáveis na sessão para não reaparecer em refresh
unset($_SESSION['registro_erros'], $_SESSION['registro_old']);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TechPet - Registrar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
          crossorigin="anonymous">
    <link rel="stylesheet" href="../registre-se/registre-se.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger w-75">
        <ul class="mb-0">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form id="formRegistreSe" action="./registre-se_processo.php" method="post" 
          class="d-flex flex-column justify-content-center align-items-center shadow p-4 m-5" 
          style="border-radius: 1rem; width: 90%; max-width: 480px;">
        <legend class="col-11 h6">Informações para Cadastro</legend>
        <fieldset class="col-11 h-auto w-auto border p-3" style="border-radius: 1rem;">
            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="name" id="label-name" class="mt-2">Nome: </label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  class="border-left-0 border-right-0 border-top-0 border ml-2 mr-2  p-1"
                  placeholder="Digite o seu nome completo"
                  value="<?= htmlspecialchars($old['name']   ?? '') ?>"
                  required
                >
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="senhaRegistro" id="label-senha" class="mt-2">Senha: </label>
                <div class=" col-11 border-left-0 border-right-0 border-top-0 border ml-2 d-flex p-1">
                    <input
                    type="password"
                    name="senhaRegistro"
                    id="senhaRegistro"
                    class="border-0"
                    placeholder="Crie uma senha"
                    required
                    >
                    <i class="fa-solid fa-eye-slash fa-sm icon-input" id="icon-input-senha"></i>
                </div>
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="confirmarSenhaRegistro" id="label-confirmar" class="mt-2">Confirme a senha: </label>
                <div class=" col-11 border-left-0 border-right-0 border-top-0 border ml-2 d-flex p-1">
                    <input
                    type="password"
                    name="confirmarSenhaRegistro"
                    id="confirmarSenhaRegistro"
                    class="border-0"
                    placeholder="Confirme a mesma senha"
                    required
                    >
                    <i class="fa-solid fa-eye-slash fa-sm icon-input" id="icon-input-confirmar-senha"></i>
                </div>
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="estados" id="label-estado" class="mt-2">Estado: </label>
                <select
                  name="estados"
                  id="estados"
                  class="border-0"
                  required
                >
                  <option value="">Selecione um estado</option>
                  <!-- Exemplo de opções; marque o selecionado conforme $old -->
                  <option value="SP" <?= (isset($old['estados']) && $old['estados'] === 'SP') ? 'selected' : '' ?>>São Paulo</option>
                  <option value="RJ" <?= (isset($old['estados']) && $old['estados'] === 'RJ') ? 'selected' : '' ?>>Rio de Janeiro</option>
                  <option value="MG" <?= (isset($old['estados']) && $old['estados'] === 'MG') ? 'selected' : '' ?>>Minas Gerais</option>
                  <!-- Acrescente as demais opções de estados aqui -->
                </select>
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="cidades" id="label-cidade" class="mt-2">Cidade: </label>
                <select
                  name="cidades"
                  id="cidades"
                  class="border-0"
                  required
                >
                  <option value="">Selecione uma cidade</option>
                  <!-- Se você popula cidades via JS, apenas marque o valor antigo -->
                  <?php if (isset($old['cidades']) && $old['cidades'] !== ''): ?>
                    <option value="<?= htmlspecialchars($old['cidades']) ?>" selected>
                      <?= htmlspecialchars($old['cidades']) ?>
                    </option>
                  <?php endif; ?>
                </select>
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="email" id="label-email" class="mt-2">E-mail: </label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="border-0"
                  placeholder="Digite o seu e-mail"
                  value="<?= htmlspecialchars($old['email']  ?? '') ?>"
                  required
                >
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="dtnasc" id="label-dtnasc" class="mt-2">Data de nascimento: </label>
                <input
                  type="date"
                  name="dtnasc"
                  id="dtnasc"
                  class="border-0"
                  placeholder="Digite a sua data de nascimento"
                  value="<?= htmlspecialchars($old['dtnasc']  ?? '') ?>"
                  required
                >
            </div>

            <div class="col-12 justify-content-start align-items-start m-1">
                <label for="wpp" id="label-wpp" class="mt-2">Número de celular:</label>
                <input
                  type="tel"
                  name="wpp"
                  id="wpp"
                  class="border-0"
                  placeholder="Digite o seu número"
                  value="<?= htmlspecialchars($old['wpp']    ?? '') ?>"
                  required
                >
            </div>
        </fieldset>

        <button type="submit" id="enviar" class="btn col-11 mt-3" style="background-color: #5beeba; color: white;">
          Enviar
        </button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"
            integrity="sha384-ZvpUoO/+Pv3IPm49EF+5GcgLit/smW1xSYJkGxWAwHgtlU3hq8CV3w1uU8Fg5/WN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../registre-se/registre-se.js"></script>
    <script src="../registre-se/validacao.js"></script>
</body>
</html>
