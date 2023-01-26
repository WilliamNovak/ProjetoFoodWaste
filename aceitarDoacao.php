<?php
    session_start();
    include_once('database.php');
    
    $userId = $_SESSION['userId'];
    $today = date('y-m-d');
    $errors = 0;
    $msg;

    $idDoacao = $_POST['iddoacao'];

    $query_doacao = "SELECT iddoador, idalimento, quantidade FROM doacao WHERE iddoacao = ?";
    $res_doacao = $conexao->prepare($query_doacao);
    $res_doacao->execute([$idDoacao]);
    $row_doacao = $res_doacao->fetch(PDO::FETCH_ASSOC);

    $idAlimento = $row_doacao['idalimento'];
    $amount = $row_doacao['quantidade'];

    $query_validade = "SELECT prazo_validade FROM alimentos WHERE idalimento = ?";
    $res_validade = $conexao->prepare($query_validade);
    $res_validade->execute([$idAlimento]);
    $row_validade = $res_validade->fetch(PDO::FETCH_ASSOC);

    $validity = date('y-m-d', strtotime($row_validade['prazo_validade']));

    if ($validity <= $today) {

        $query_update = "UPDATE alimentos SET quantidade = quantidade + ? WHERE idalimento = ?";
        $res = $conexao->prepare($query_update);
        $res->execute([$amount, $idAlimento]);

        $query_recusado = "UPDATE doacao SET situacao = 'R' WHERE iddoacao = ?";
        $res = $conexao->prepare($query_recusado);
        $res->execute([$idDoacao]);

        $errors++;
        $msg = "Alimento vencido. Doação retornada para o doador!";

    } else {
        $query_aceito = "UPDATE doacao SET situacao = 'A' WHERE iddoacao = ?";
        $res = $conexao->prepare($query_aceito);
        $res->execute([$idDoacao]);

        $msg = "Doação recebida com sucesso!";
    }

    $arr = array('errors' => $errors, 'msg' => $msg);
    echo json_encode($arr);
?>