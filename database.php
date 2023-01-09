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

    $conexao = @mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName) or die(
        "<script language='javascript' type='text/javascript'>
            alert('Erro ao se conectar com o banco de dados!');
            window.location.href='{$pg_anterior}';
        </script>");

    if (!$conexao) {
        echo "<br>ERRO: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    mysqli_set_charset($conexao,'utf8');

?>