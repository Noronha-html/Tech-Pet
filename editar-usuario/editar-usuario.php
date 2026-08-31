<?php
session_start();
include_once "../conn.php";

// 1) Verifica login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
$usuarioId = $_SESSION['usuario_id'];

// 2) Busca dados atuais
$sql = "SELECT Nome, Email, Estado, Cidade, DataNascimento, Whatsapp
          FROM pessoas
         WHERE PessoaID = ? AND Excluido = 0
         LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    exit("Usuário não encontrado.");
}
$user = $res->fetch_assoc();
$stmt->close();

$atualizador = 't=' . base64_encode(date('YmdHis') . rand());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TechPet – Editar Perfil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="editar-usuario.css?<?= $atualizador ?>">
</head>
<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <?php
    $errs = $_SESSION['edit_usuario_errors'] ?? [];
    unset($_SESSION['edit_usuario_errors']);
    if($errs): ?>
    <div class="alert alert-danger w-75"><?php
        foreach($errs as $e) echo "<div>".htmlspecialchars($e)."</div>";
    ?></div>
    <?php endif; ?>
  <form id="formEditarUsuario" action="editar-usuario_processo.php" method="post"
        class="shadow p-4 m-5 bg-white" style="border-radius:1rem; width:90%;max-width:480px;">
    <h2 class="mb-4">Editar Perfil</h2>
    <input type="hidden" name="usuario_id" value="<?= $usuarioId ?>">

    <div class="form-group">
      <label for="name">Nome:</label>
      <input type="text" id="name" name="name" class="form-control"
             value="<?= htmlspecialchars($user['Nome']) ?>" required>
    </div>

    <div class="form-group">
      <label for="email">E‑mail:</label>
      <input type="email" id="email" name="email" class="form-control"
             value="<?= htmlspecialchars($user['Email']) ?>" required>
    </div>

    <div class="form-group">
      <label for="estados">Estado:</label>
      <select id="estados" name="estados" class="form-control" required>
        <option value="">Selecione um estado</option>
        <option value="SP" <?= $user['Estado']==='SP'?'selected':'' ?>>São Paulo</option>
        <option value="RJ" <?= $user['Estado']==='RJ'?'selected':'' ?>>Rio de Janeiro</option>
        <option value="MG" <?= $user['Estado']==='MG'?'selected':'' ?>>Minas Gerais</option>
        <!-- demais estados -->
      </select>
    </div>

    <div class="form-group">
      <label for="cidades">Cidade:</label>
      <select id="cidades" name="cidades" class="form-control" required>
        <option value="<?= htmlspecialchars($user['Cidade']) ?>" selected>
          <?= htmlspecialchars($user['Cidade']) ?>
        </option>
      </select>
    </div>

    <div class="form-group">
      <label for="dtnasc">Data de Nascimento:</label>
      <input type="date" id="dtnasc" name="dtnasc" class="form-control"
             value="<?= htmlspecialchars($user['DataNascimento']) ?>" required>
    </div>

    <div class="form-group">
      <label for="wpp">Celular (WhatsApp):</label>
      <input type="tel" id="wpp" name="wpp" class="form-control"
             value="<?= htmlspecialchars($user['Whatsapp']) ?>" required>
    </div>

    <button type="submit" class="btn btn-block" style="background-color: #5beeba; color: white;">Salvar Alterações</button>
  </form>

  <script src="editar-usuario.js?<?= $atualizador ?>"></script>
  <script src="validacao.js"></script>
</body>
</html>
