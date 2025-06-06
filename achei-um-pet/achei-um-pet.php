<?php
session_start();
include_once "../conexao.php"; // Ajuste este caminho se a sua conexão estiver em local diferente

$erro = "";

// 1) Processa o POST quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura o número de série enviado pelo usuário
    $serial = trim($_POST['numeroSerie'] ?? '');
    if ($serial === '') {
        $erro = "Por favor, digite o número de série.";
    } else {
        // Verifica se existe algum pet com esse Identificacao (número de série)
        $stmt = $conn->prepare(" SELECT PetID
              FROM pets
             WHERE Identificacao = ?
               AND Excluido = 0
            LIMIT 1
        ");
        $stmt->bind_param("s", $serial);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res && $res->num_rows > 0) {
            // Redireciona para a página que exibe os detalhes do pet
            header("Location: ../pet/pet.php?serial=" . urlencode($serial));
            exit;
        } else {
            $erro = "Pet não encontrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit=no">
    <title>TechPet - Achar Pet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../achei-um-pet/achei-um-pet.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="d-flex flex-column min-vh-100 justify-content-center align-items-center">

    <?php if ($erro !== ""): ?>
      <div class="alert alert-danger w-25 text-center" style="font-weight: 600;">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <form action="" method="post" class="d-flex row w-auto flex-column justify-content-center align-items-center shadow p-4 m-4" style="border-radius: 1rem;">
        <legend class="col-11 h6">Digite o <strong>número</strong><br> abaixo do QR code</legend>
        <fieldset class="col-11 border p-3 mt-2" style="border-radius: 1rem;">
            <div class="col-12 justify-content-start align-items-start">
                <label for="numeroSerie" class="mt-2 border-0">Número de Série:</label>
                <input
                  type="text"
                  id="numeroSerie"
                  name="numeroSerie"
                  class="border-top-0 border-left-0 border-right-0 border-bottom"
                  placeholder="#123"
                  required
                  value="<?= isset($_POST['numeroSerie']) ? htmlspecialchars($_POST['numeroSerie']) : '' ?>"
                >
            </div>
        </fieldset>
        <button type="submit" class="btn btn-success col-6 mt-3" style="background-color: #5beeba; border: none;">Buscar Pet</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a0cfbec9a7.js" crossorigin="anonymous"></script>

    <script src="../pet/pet.js?<?php echo 't=' . base64_encode(date('YmdHis')); ?>"></script>
</body>
</html>
