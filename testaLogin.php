<?php

if(isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['password'])){

    include_once('database.php');

    $user = $_POST['user'];
    $password = $_POST['password'];

    $queryDados = mysqli_query($conexao,"SELECT nome_usuario, senha FROM usuario WHERE nome_usuario = '$user'");

    if(mysqli_num_rows($queryDados) < 1){
        header('Location: login.php');
    }
    else{
        while ($result = mysqli_fetch_array( $queryDados )){
        
            if (password_verify($password, $result['senha'])) {
                header('Location: index.php');
            }
            else {
                header('Location: login.php');
            }
        }
    }


}

?>