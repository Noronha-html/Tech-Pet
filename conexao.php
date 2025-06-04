<?php

$host = "mysql.techpet.app.br";
$user = "techpet";
$password = "aN3L8TE88dyJ";
$db = "techpet";

$conn = new mysqli($host, $user, $password, $db);

// Verificar se houve erro
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
