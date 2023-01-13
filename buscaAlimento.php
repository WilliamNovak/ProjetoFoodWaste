<?php
    header('Content-Type: application/json');
    include_once('database.php');

    $idAlimento = $_POST['id'];

    $data = "SELECT * FROM alimentos WHERE idalimento = '{$idAlimento}'";
    $res = $conexao->query($data);

    // $arr = array('errors' => $errors, 'userError' => $user_error, 'telError' => $tel_error, 'emailError' => $email_error, 'cnpjError' => $cnpj_error);
    echo json_encode($data);
?>