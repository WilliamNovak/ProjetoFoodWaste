<?php
    session_start();
    include_once('database.php');
    
    $userId = $_SESSION['userId'];
    $idAlimento = $_POST['id'];
    $amount = $_POST['amount'];
    $today = date('y-m-d');
    $errors = 0;

    $query_amount = "SELECT quantidade FROM alimentos WHERE idalimento = ?";
    $res_amount = $conexao->prepare($query_amount);
    $res_amount->execute([$idAlimento]);
    $row_amount = $res_amount->fetch(PDO::FETCH_ASSOC);
    
    $existAmount = $row_amount['quantidade'];
    $newAmount = $existAmount - $amount;

    $sql_total_receivers = "SELECT COUNT(u.idusuario) as total FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R'";
    $res_total_receivers = $conexao->prepare($sql_total_receivers);
    $res_total_receivers->execute();
    $row = $res_total_receivers->fetch(PDO::FETCH_ASSOC);
    $total_receivers = $row['total'];

    if ($total_receivers > 0 && $newAmount >= 0 && $amount != 0) {

        $sql_num_receivers = "SELECT COUNT(u.idusuario) as total FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R' AND NOT EXISTS (SELECT 1 FROM doacao d WHERE d.idreceptor = u.idusuario)";
        $res_num_receivers = $conexao->prepare($sql_num_receivers);
        $res_num_receivers->execute();
        $rows_receivers = $res_num_receivers->fetch(PDO::FETCH_ASSOC);
        $num_receivers = $rows_receivers['total'];

        if ($num_receivers == 1) {

            $query_receiver = "SELECT u.idusuario FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R' AND NOT EXISTS (SELECT 1 FROM doacao d WHERE d.idreceptor = u.idusuario)";
            $res = $conexao->prepare($query_receiver);
            $res->execute();
            $row_receiver = $res->fetch(PDO::FETCH_ASSOC);
            $idReceiver = $row_receiver['idusuario'];

            $query_donation = "INSERT INTO doacao (iddoador, idreceptor, idalimento, quantidade, data_doacao, situacao) VALUES (?, ?, ?, ?, ?, 'E')";
            $res = $conexao->prepare($query_donation);
            $res->execute([$userId, $idReceiver, $idAlimento, $amount, $today]);

        } else if ($num_receivers > 1) {

            $query_receiver = "SELECT u.idusuario FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R' AND NOT EXISTS (SELECT 1 FROM doacao d WHERE d.idreceptor = u.idusuario) order by rand() LIMIT 1";
            $res = $conexao->prepare($query_receiver);
            $res->execute();
            $row_receiver = $res->fetch(PDO::FETCH_ASSOC);
            $idReceiver = $row_receiver['idusuario'];

            $query_donation = "INSERT INTO doacao (iddoador, idreceptor, idalimento, quantidade, data_doacao, situacao) VALUES (?, ?, ?, ?, ?, 'E')";
            $res = $conexao->prepare($query_donation);
            $res->execute([$userId, $idReceiver, $idAlimento, $amount, $today]);

        } else {

            $query_receivers = "SELECT u.idusuario FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R'";
            $res = $conexao->prepare($query_receivers);
            $res->execute();

            while($data = $res->fetch(PDO::FETCH_ASSOC)){

                $query_type = "SELECT idtipo FROM alimentos WHERE idalimento = ?";
                $res_type = $conexao->prepare($query_type);
                $res_type->execute([$idAlimento]);
                $row_type = $res_type->fetch(PDO::FETCH_ASSOC);
                $foodType = $row_type['idtipo'];

                $currentDate = new DateTime($today);

                $query_data = "SELECT max(d.data_doacao) as data_doacao FROM doacao d WHERE idreceptor = ?";
                $res_data = $conexao->prepare($query_data);
                $res_data->execute([$data['idusuario']]);
                $row_data = $res_data->fetch(PDO::FETCH_ASSOC);
                $lastDonation = new DateTime($row_data['data_doacao']);

                $days = date_diff($lastDonation,$currentDate)->d;

                $query_data_type = "SELECT max(d.data_doacao) as data_doacao FROM doacao d, alimentos a WHERE d.idalimento = a.idalimento AND a.idtipo = ? AND d.idreceptor = ?";
                $res_data_type = $conexao->prepare($query_data_type);
                $res_data_type->execute([$foodType, $data['idusuario']]);
                $row_data_type = $res_data_type->fetch(PDO::FETCH_ASSOC);
                $lastDonationType = new DateTime($row_data_type['data_doacao']);

                $daysType = date_diff($lastDonationType,$currentDate)->d;

                $query_tot_donation = "SELECT count(iddoacao) as total FROM doacao WHERE idreceptor = ?";
                $res_tot_donation = $conexao->prepare($query_tot_donation);
                $res_tot_donation->execute([$data['idusuario']]);
                $rows_donation = $res_tot_donation->fetch(PDO::FETCH_ASSOC);
                $totalDonations = $rows_donation['total'];

                $query_donation_type = "SELECT count(d.iddoacao) as total FROM doacao d, alimentos a WHERE d.idalimento = a.idalimento AND a.idtipo = ? AND d.idreceptor = ?";
                $res_donation_type = $conexao->prepare($query_donation_type);
                $res_donation_type->execute([$foodType, $data['idusuario']]);
                $rows_donation_type = $res_donation_type->fetch(PDO::FETCH_ASSOC);
                $totalDonationsType = $rows_donation_type['total'];
            }
        }

        $query_update = "UPDATE alimentos SET quantidade = quantidade - ? WHERE idalimento = ?";
        $res = $conexao->prepare($query_update);
        $res->execute([$amount, $idAlimento]);
        
    } else {
        $errors++;
    }

    $arr = array('id' => $idAlimento, 'receivers' => $total_receivers, 'errors' => $errors);
    echo json_encode($arr);
?>