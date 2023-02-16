<?php

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPassword = 'root';
    $dbName = 'projeto';

    setlocale(LC_ALL,'pt_BR.UTF8');
    mb_internal_encoding('UTF8');
    mb_regex_encoding('UTF8');

    $escape = 'http://localhost/ProjetoFoodWaste/index.php';
    $pg_anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $escape;

    try {
        $conexao = new PDO("mysql:host=$dbHost;dbname=$dbName; charset=utf8", $dbUser , $dbPassword);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Erro:" . $e->getMessage();
    }

?>