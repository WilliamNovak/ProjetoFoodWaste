<?php

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPassword = '';
    $dbName = 'projeto';

    $conexao = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // //--------------------//
    // // Teste de conexão 
    // //--------------------//
    // /*
    // if($conexao -> connect_errno){
    //     echo "Erro de conexão ao banco de dados!";
    // }
    // else{
    //     echo "Conexão estabelecida com sucesso!";
    // }


?>