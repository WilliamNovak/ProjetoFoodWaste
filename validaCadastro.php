<?php
    require_once("./template.php");

    // echo "<script language='javascript' type='text/javascript'>
    //     alert('ooooooooo!');
    // </script>";

    $username = $_POST['username'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $errors = 0;
    $user_error = 0;
    $tel_error = 0;
    $email_error = 0;

    $userExist = "SELECT * FROM usuario WHERE nome_usuario = '{$username}'";
    $userResult = mysqli_query($conexao,$userExist);
    if(mysqli_num_rows($userResult) > 0) {
        $errors++;
        $user_error++;
    }

    $telExist = "SELECT * FROM usuario WHERE telefone = '{$tel}'";
    $telResult = mysqli_query($conexao,$telExist);
    if(mysqli_num_rows($telResult) > 0) {
        $errors++;
        $tel_error++;
    }

    $emailExist = "SELECT * FROM usuario WHERE email = '{$email}'";
    $emailResult = mysqli_query($conexao,$emailExist);
    if(mysqli_num_rows($emailResult) > 0) {
        $errors++;
        $email_error++;
    }

    $arr = array('errors' => $errors, 'userError' => $user_error, 'telError' => $tel_error, 'emailError' => $email_error);
    json_encode($arr);
?>