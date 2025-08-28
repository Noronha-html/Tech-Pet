<?php
// enviar_email.php
// Handler pronto — usa remetente fixo e destinatário fixo.
// Coloque este arquivo na mesma pasta do portfolio.php.
// NÃO coloque senhas em repositórios públicos.

declare(strict_types=1);

/**
 * Limpeza básica
 */
function clean_input(string $s, int $max = 2000): string {
    $s = trim($s);
    $s = substr($s, 0, $max);
    $s = str_replace("\0", '', $s);
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function has_header_injection(string $s): bool {
    return preg_match("/[\r\n]/", $s) === 1;
}

/**
 * E-mails pré-setados (conforme solicitado)
 */
const SENDER_FIXED   = 'peyer.f31@gmail.com';                 // remetente fixo
const RECEIVER_FIXED = 'arthur.p.fernandes.31@gmail.com';     // destinatário fixo

/**
 * SMTP (opcional). Para usar SMTP: habilite abaixo e preencha a senha.
 * Para Gmail, use App Password (conta com 2FA).
 */
$SMTP_ENABLED = true;                // habilita envio via SMTP
$SMTP_HOST    = 'smtp.gmail.com';
$SMTP_PORT    = 587;
$SMTP_USER    = SENDER_FIXED;        // remetente fixo (peyer.f31@gmail.com)
$SMTP_PASS    = 'jmvn ktco plqi sbyh'; // sua App Password
$SMTP_SECURE  = 'tls';               // 'tls' ou 'ssl'

/* ---------- início do processamento ---------- */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método não permitido.";
    exit;
}

$nome          = isset($_POST['nome']) ? clean_input((string)$_POST['nome']) : '';
$email_usuario = isset($_POST['email']) ? clean_input((string)$_POST['email']) : ''; // opcional
$assunto       = isset($_POST['assunto']) ? clean_input((string)$_POST['assunto']) : 'Contato pelo site';
$mensagem      = isset($_POST['mensagem']) ? clean_input((string)$_POST['mensagem'], 8000) : '';

$errors = [];

// validações essenciais (não exige email)
if ($nome === '') { $errors[] = 'O campo Nome é obrigatório.'; }
if ($mensagem === '') { $errors[] = 'A mensagem não pode ficar vazia.'; }
if (has_header_injection($nome) || has_header_injection($assunto)) {
    $errors[] = 'Dados inválidos detectados.';
}

// Se visitante forneceu email, valide-o
$email_valido = false;
if ($email_usuario !== '') {
    if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL) || has_header_injection($email_usuario)) {
        $errors[] = 'E-mail inválido.';
    } else {
        $email_valido = true;
    }
}

if (!empty($errors)) {
    http_response_code(400);
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Erro</title></head><body>";
    echo "<h2>Erro ao enviar a mensagem</h2>\n<ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo "</ul>\n<p>Volte e corrija os dados.</p>";
    echo "<p><a href='javascript:history.back()'>Voltar</a></p>";
    echo "</body></html>";
    exit;
}

// Monta corpo do e-mail
$site = $_SERVER['HTTP_HOST'] ?? 'site';
$subject_email = "[" . $site . "] " . $assunto;

$body  = "Você recebeu uma nova mensagem de contato.\n\n";
$body .= "Nome: {$nome}\n";
$body .= "E-mail (visitante): " . ($email_usuario !== '' ? $email_usuario : 'Não informado') . "\n";
$body .= "Assunto: {$assunto}\n\n";
$body .= "Mensagem:\n{$mensagem}\n\n";
$body .= "----\n";
$body .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";
$body .= "User-Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'N/A') . "\n";

$sent = false;
$smtp_error = '';

/* Tenta SMTP com PHPMailer se habilitado */
if ($SMTP_ENABLED) {
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/../../vendor/autoload.php';
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = $SMTP_USER;
            $mail->Password   = $SMTP_PASS;
            $mail->SMTPSecure = $SMTP_SECURE;
            $mail->Port       = (int)$SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SENDER_FIXED, $site . ' - Formulário');
            $mail->addAddress(RECEIVER_FIXED);

            if ($email_valido) {
                $mail->addReplyTo($email_usuario, $nome);
            }

            $mail->Subject = $subject_email;
            $mail->Body    = $body;
            $mail->isHTML(false);

            $mail->send();
            $sent = true;
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            $smtp_error = 'PHPMailer error: ' . $e->getMessage();
            $sent = false;
        }
    } else {
        $smtp_error = 'PHPMailer não encontrado. Rode `composer require phpmailer/phpmailer` ou desative SMTP no handler.';
    }
}

/* Se não enviou por SMTP, tenta mail() do PHP */
if (!$sent) {
    $headers  = 'From: ' . SENDER_FIXED . "\r\n";
    if ($email_valido) {
        $headers .= 'Reply-To: ' . $email_usuario . "\r\n";
    } else {
        $headers .= 'Reply-To: ' . SENDER_FIXED . "\r\n";
    }
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $ok = @mail(RECEIVER_FIXED, $subject_email, $body, $headers);
    if ($ok) {
        $sent = true;
    } else {
        $sent = false;
        if ($smtp_error === '') {
            $smtp_error = 'Função mail() retornou false. Verifique configuração do servidor SMTP ou use SMTP com PHPMailer.';
        }
    }
}

/* Resultado ao usuário */
if ($sent) {
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Mensagem enviada</title></head><body>";
    echo "<h2>Mensagem enviada com sucesso ✅</h2>";
    echo "<p>Obrigado, " . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . ". Sua mensagem foi enviada.</p>";
    echo "<p><a href='javascript:history.back()'>Voltar</a></p>";
    echo "</body></html>";
    exit;
} else {
    http_response_code(500);
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Erro</title></head><body>";
    echo "<h2>Não foi possível enviar a mensagem ❌</h2>";
    echo "<p>Detalhes: " . htmlspecialchars($smtp_error, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p>Se estiver em ambiente local (XAMPP/WAMP) a função <code>mail()</code> normalmente não funciona. Recomendações:</p>";
    echo "<ul>";
    echo "<li>Habilitar SMTP e configurar PHPMailer (preencha as credenciais no topo do arquivo e rode <code>composer require phpmailer/phpmailer</code>).</li>";
    echo "<li>Ou usar um serviço de envio (SendGrid/Mailgun) via API/SMTP.</li>";
    echo "</ul>";
    echo "<p><a href='javascript:history.back()'>Voltar</a></p>";
    echo "</body></html>";
    exit;
}
