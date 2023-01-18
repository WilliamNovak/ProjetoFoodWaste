<?php
    session_start();
    include_once('database.php');

    $idAlimento = $_POST['id'];
    $amount = $_POST['amount'];

    $arr = array('id' => $idAlimento, 'amount' => $amount);
    echo json_encode($arr);
?>