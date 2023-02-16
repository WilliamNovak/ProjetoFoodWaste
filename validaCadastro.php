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
    $database_error = "";

    try {
        $userExist = $conexao->prepare("SELECT count(*) FROM usuario WHERE nome_usuario = ?");
        $userExist->execute([$username]);
        $userResult = $userExist->fetchColumn();
        if($userResult > 0) {
            $errors++;
            $user_error++;
        }

        $telExist = $conexao->prepare("SELECT count(*) FROM usuario WHERE telefone = ?");
        $telExist->execute([$tel]);
        $telResult = $telExist->fetchColumn();
        if($telResult > 0) {
            $errors++;
            $tel_error++;
        }

        $emailExist = $conexao->prepare("SELECT count(*) FROM usuario WHERE email = ?");
        $emailExist->execute([$email]);
        $emailResult = $emailExist->fetchColumn();
        if($emailResult > 0) {
            $errors++;
            $email_error++;
        }

        $cnpjExist = $conexao->prepare("SELECT count(*) FROM usuario WHERE cnpj = ?");
        $cnpjExist->execute([$cnpj]);
        $cnpjResult = $cnpjExist->fetchColumn();
        if($cnpjResult > 0) {
            $errors++;
            $cnpj_error++;
        }
    } catch (PDOException $e) {
        $errors++;
        $database_error = "Erro: " . $e->getMessage();
    }

    $arr = array('errors' => $errors, 'userError' => $user_error, 'telError' => $tel_error, 'emailError' => $email_error, 'cnpjError' => $cnpj_error, 'databaseError' => $database_error);
    echo json_encode($arr);
?>