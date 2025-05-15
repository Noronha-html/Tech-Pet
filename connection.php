<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "techpet";

    $conn = new mysqli($host, $user, $password, $db);

    if(!($conn)){
        echo "Conexão não estabelecida";
    }
?>