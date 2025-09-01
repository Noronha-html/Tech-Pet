<?php/*
declare(strict_types=1);

/**
 * enviar_email.php
 * Local: Tech-Pet/img/teste/enviar_email.php
 * Envia mensagens via SMTP (PHPMailer). Destinatário final: arthur.p.fernandes.31@gmail.com
 *
 * Observações:
 * - Ajuste as credenciais SMTP/paths se necessário.
 * - Em produção, mova usuário/senha SMTP para variáveis de ambiente.
 */ 

// resposta em texto simples/*
//header('Content-Type: text/plain; charset=utf-8')*/     

// somente POST
//if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   // http_response_code(405);
   // echo 'Método não permitido.';
   // exit;
//}

// tenta localizar autoload do composer em caminhos comuns (robusto)
//$possibleAutoload = [
//    __DIR__ . '/../../vendor/autoload.php',    // caso arquivo esteja em img/teste (img/teste -> ../../vendor)
//    __DIR__ . '/../vendor/autoload.php',       // caso esteja em img/
//    __DIR__ . '/vendor/autoload.php',          // caso esteja junto ao vendor
//    __DIR__ . '/../../../vendor/autoload.php', // tentativa extra
//];
//
//$autoloadFound = false;
//foreach ($possibleAutoload as $p) {
//    if (file_exists($p)) {
//        require_once $p;
//        $autoloadFound = true;
//        break;
//    }
//}
//
//if (! $autoloadFound) {
//    http_response_code(500);
//    error_log('enviar_email.php: composer autoload not found. Paths tried: ' . implode(', ', $possibleAutoload));
//    echo 'Erro interno (autoload não encontrado).';
//    exit;
//}
//
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
// sanitização básica
//function in_str(string $k): string {
//    return trim((string)($_POST[$k] ?? ''));
//}

//$nome     = in_str('nome');
//$email    = in_str('email');    // opcional
//$assunto  = in_str('assunto') ?: 'Contato pelo site';
//$mensagem = in_str('mensagem');

// validações mínimas
//if ($nome === '' || $mensagem === '') {
//    http_response_code(400);
//    echo 'Por favor preencha nome e mensagem.';
//    exit;
//}
//
// SMTP — ajuste se quiser usar env vars
//$SMTP_HOST   = 'smtp.kinghost.net';
//$SMTP_PORT   = 587; // 587 (TLS) geralmente funciona
//$SMTP_USER   = 'contato@techpet.app.br';
//$SMTP_PASS   = 'aPnQ@j5K#3YL'; // considere mover para getenv(...) em produção
//$SMTP_SECURE = 'tls'; // 'tls' para 587, 'ssl' para 465

// destinatário final (conforme pedido)
//$DEST_EMAIL = 'arthur.p.fernandes.31@gmail.com';
//$DEST_NAME  = 'Arthur Fernandes';

//try {
//    $mail = new PHPMailer(true);

    // configuração SMTP
//    $mail->isSMTP();
//    $mail->Host       = $SMTP_HOST;
//    $mail->SMTPAuth   = true;
//    $mail->Username   = $SMTP_USER;
//    $mail->Password   = $SMTP_PASS;
//    $mail->SMTPSecure = $SMTP_SECURE;
//    $mail->Port       = (int)$SMTP_PORT;
//    $mail->CharSet    = 'UTF-8';

    // remetente (deve ser do domínio autenticado)//
//    $mail->setFrom($SMTP_USER, 'TechPet - Site');

    // destinatário (Arthur)
//    $mail->clearAddresses();
//    $mail->addAddress($DEST_EMAIL, $DEST_NAME);

    // se visitante forneceu email válido, adiciona Reply-To
//    if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        $mail->addReplyTo($email, $nome);
//    }

    // conteúdo
//    $mail->isHTML(true);
//    $mail->Subject = "[Site] " . $assunto;

    // corpo em HTML e texto simples
//    $bodyHtml = "<p><strong>Nome:</strong> " . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . "</p>"
//              . "<p><strong>E-mail:</strong> " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</p>"
//              . "<p><strong>Mensagem:</strong><br/>" . nl2br(htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8')) . "</p>";

//    $bodyText = "Nome: $nome\nE-mail: $email\n\nMensagem:\n$mensagem";

//    $mail->Body    = $bodyHtml;
//    $mail->AltBody = $bodyText;

//    $mail->send();

    // resposta simples compatível com seu portfolio.js
//    echo 'Mensagem enviada com sucesso';
//    exit;
//} catch (Exception $e) {
    // registra no log do servidor (não expor detalhes ao usuário)
//    error_log('enviar_email.php - mail error: ' . $e->getMessage());
//    http_response_code(500);
//    echo 'Erro ao enviar mensagem. Tente novamente mais tarde.';
//    exit;
//}*/ ?>