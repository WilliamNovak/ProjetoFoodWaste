<?php
    header('Content-Type: application/json');
    include_once('database.php');

    $username = $_POST['username'];
    $tel = preg_replace("/[^0-9]/", "", $_POST['tel']);
    $cnpj = preg_replace("/[^0-9]/", "", $_POST['cnpj']);
    $email = $_POST['email'];
    $errors = 0;
    $user_error = 0;
    $tel_error = 0;
    $email_error = 0;
    $cnpj_error = 0;

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

    $cnpjExist = "SELECT * FROM usuario WHERE cnpj = '{$cnpj}'";
    $cnpjResult = mysqli_query($conexao,$cnpjExist);
    if(mysqli_num_rows($cnpjResult) > 0) {
        $errors++;
        $cnpj_error++;
    }

    $arr = array('errors' => $errors, 'userError' => $user_error, 'telError' => $tel_error, 'emailError' => $email_error, 'cnpjError' => $cnpj_error);
    echo json_encode($arr);
?>