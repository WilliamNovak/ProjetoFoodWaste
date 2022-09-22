<?php
session_start();

if(isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['password'])){

    include_once('database.php');

    $user = preg_replace('/[^[:alnum:]_]/', '',$_POST['user']);
    $password = preg_replace('/[^[:alnum:]_]/', '',$_POST['password']);

    $queryDados = mysqli_query($conexao,"SELECT nome_usuario, senha FROM usuario WHERE nome_usuario = '$user'");

    if(mysqli_num_rows($queryDados) < 1)
    {
        unset($_SESSION['user']);
        unset($_SESSION['password']);
        unset($_SESSION['userType']);
        header('Location: login.php');
    }
    else{
        while ($result = mysqli_fetch_array( $queryDados )){
        
            if (password_verify($password, $result['senha'])) {
                $_SESSION['user'] = $user;
                $_SESSION['password'] = $password;
                $query = mysqli_query($conexao,"SELECT tipo_usuario FROM usuario WHERE nome_usuario = '$user'");
                $row = mysqli_fetch_row($query);
                $_SESSION['userType'] = $row[0];
                header('Location: index.php');
            }
            else {
                unset($_SESSION['user']);
                unset($_SESSION['password']);
                unset($_SESSION['userType']);
                header('Location: login.php');
            }
        }
    }

}
else{
    unset($_SESSION['user']);
    unset($_SESSION['password']);
    unset($_SESSION['userType']);
    header('Location: login.php');
}

?>