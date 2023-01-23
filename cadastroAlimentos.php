<?php
    session_start();

    include_once('database.php');
    $userId = $_SESSION['userId'];

    $food = $_POST['food'];
    $foodType = $_POST['foodType'];
    $amount = $_POST['amount'];
    $unit = $_POST['unit'];
    $validity = $_POST['validity'];
    $foodId = $_POST['id'];

    $msg;

    if (!empty($foodId)) {

        $query = "UPDATE alimentos SET idtipo = ?, descricao = ?, prazo_validade = ?, quantidade = ?, unidade_medida = ? WHERE idalimento = ?";
        $res = $conexao->prepare($query);
        $res->execute([$foodType, $food, $validity, $amount, $unit, $foodId]);

        $msg = "Alimento atualizado com sucesso!";

    } else {
        $query = "INSERT INTO alimentos (idproprietario, idtipo, descricao, prazo_validade, quantidade, unidade_medida, situacao) VALUES (?, ?, ?, ?, ?, ?, 'E')";
        $res = $conexao->prepare($query);
        $res->execute([$userId, $foodType, $food, $validity, $amount, $unit]);

        $msg = "Alimento cadastrado com sucesso!";
    }

    echo json_encode($msg);
?>