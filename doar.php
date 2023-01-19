<?php
    session_start();
    include_once('database.php');
    
    $userId = $_SESSION['userId'];
    $idAlimento = $_POST['id'];
    $amount = $_POST['amount'];
    $today = date('d/m/Y');
    $errors = 0;

    $query_amount = "SELECT quantidade FROM alimentos WHERE idalimento = ?";
    $res_amount = $conexao->prepare($query_amount);
    $res_amount->execute([$idAlimento]);
    $row_amount = $res_amount->fetch(PDO::FETCH_ASSOC);
    
    $existAmount = $row_amount['quantidade'];
    $newAmount = $existAmount - $amount;

    // Comparar tbm data doacao, pois pode ser que ja tenha doado e queira novamente o mesmo alimento
    $sql_num_receivers = "SELECT COUNT(u.idusuario) as total FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R' AND NOT EXISTS (SELECT 1 FROM doacao d WHERE d.idreceptor = u.idusuario AND d.idalimento = ? AND d.iddoador = ?)";
    $res_num_receivers = $conexao->prepare($sql_num_receivers);
    $res_num_receivers->execute([$idAlimento, $userId]);
    $rows_receivers = $res_num_receivers->fetch(PDO::FETCH_ASSOC);
    $num_receivers = $rows_receivers['total'];

    if ($num_receivers > 0 && $newAmount >= 0) {
        if ($num_receivers == 1) {

            $query_receiver = "SELECT u.idusuario FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R' AND NOT EXISTS (SELECT 1 FROM doacao d WHERE d.idreceptor = u.idusuario AND d.idalimento = ? AND d.iddoador = ?)";
            $res_receiver = $conexao->prepare($query_receiver);
            $res_receiver->execute([$idAlimento, $userId]);
            $row_receiver = $res_receiver->fetch(PDO::FETCH_ASSOC);
            $idReceiver = $row_receiver['idusuario'];

            $query_donation = "INSERT INTO doacao (iddoador, idreceptor, idalimento, quantidade, data_doacao, situacao) VALUES (?, ?, ?, ?, ?, 'E')";
            $res = $conexao->prepare($query_donation);
            $res->execute([$userId, $idReceiver, $idAlimento, $amount, $today]);

        } else {
            
        }

        $query_update = "UPDATE alimentos SET quantidade = quantidade - ? WHERE idalimento = ?";
        $res = $conexao->prepare($query_update);
        $res->execute([$amount, $idAlimento]);
        
    } else {
        $errors++;
    }

    $arr = array('id' => $idAlimento, 'receivers' => $num_receivers, 'errors' => $errors);
    echo json_encode($arr);
?>