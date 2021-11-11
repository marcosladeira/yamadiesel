<?php
    $host = 'localhost';
    $user = 'marcos';
    $pass = '12519918';
    $db_name = 'yamadieselblog';

    $conn = new MySQLi($host, $user, $pass, $db_name);
    if ($conn->connect_error) {
        die("Erro ao conectar ao DB " . $conn->connect_error);
    }
?>