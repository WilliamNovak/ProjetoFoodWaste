<?php
    session_start();
    include_once('database.php');
    
    $userId = $_SESSION['userId'];
    $today = date('y-m-d');
    $errors = 0;
    $msg;

    if (isset($_POST['id']) && isset($_POST['amount'])){

        $idAlimento = $_POST['id'];
        $amount = $_POST['amount'];
        $msg = "Doação encaminhada com sucesso!";

    } else if (isset($_POST['iddoacao'])){

        $idDoacao = $_POST['iddoacao'];
        $msg = "Doação recusada com sucesso!";

        $query_exist_doacao = "SELECT iddoador, idalimento, quantidade FROM doacao WHERE iddoacao = ?";
        $res_doacao = $conexao->prepare($query_exist_doacao);
        $res_doacao->execute([$idDoacao]);
        $row_doacao = $res_doacao->fetch(PDO::FETCH_ASSOC);

        $idAlimento = $row_doacao['idalimento'];
        $amount = $row_doacao['quantidade'];
        $userId = $row_doacao['iddoador'];

        $query_validade = "SELECT prazo_validade FROM alimentos WHERE idalimento = ?";
        $res_validade = $conexao->prepare($query_validade);
        $res_validade->execute([$idAlimento]);
        $row_validade = $res_validade->fetch(PDO::FETCH_ASSOC);

        $validity = date('y-m-d', strtotime($row_validade['prazo_validade']));
    }

    $query_amount = "SELECT quantidade FROM alimentos WHERE idalimento = ?";
    $res_amount = $conexao->prepare($query_amount);
    $res_amount->execute([$idAlimento]);
    $row_amount = $res_amount->fetch(PDO::FETCH_ASSOC);
    
    $existAmount = $row_amount['quantidade'];
    $newAmount = $existAmount - $amount;

    if (!isset($idDoacao)) {
        if ($newAmount <= 0) {
            $errors++;
            $msg = "A quantidade informada para doação é superior à quantidade em estoque.";
        } else if ($amount == 0) {
            $errors++;
            $msg = "Para realizar a doação a quantidade doada deve ser maior que 0.";
        } 
    } else {
        if ($validity <= $today) {
            $query_update = "UPDATE alimentos SET quantidade = quantidade + ? WHERE idalimento = ?";
            $res = $conexao->prepare($query_update);
            $res->execute([$amount, $idAlimento]);

            $query_recusado = "UPDATE doacao SET situacao = 'R' WHERE iddoacao = ?";
            $res = $conexao->prepare($query_recusado);
            $res->execute([$idDoacao]);

            $errors++;
            $msg = "Alimento vencido. Doação retornada para o doador!";
        }
    }
    
    if ($errors == 0) {

        $sql_total_receivers = "SELECT COUNT(u.idusuario) as total FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R'";
        $res_total_receivers = $conexao->prepare($sql_total_receivers);
        $res_total_receivers->execute();
        $row = $res_total_receivers->fetch(PDO::FETCH_ASSOC);
        $total_receivers = $row['total'];

        if ($total_receivers > 0) {

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

                $query_type = "SELECT idtipo FROM alimentos WHERE idalimento = ?";
                $res_type = $conexao->prepare($query_type);
                $res_type->execute([$idAlimento]);
                $row_type = $res_type->fetch(PDO::FETCH_ASSOC);
                $foodType = $row_type['idtipo'];

                $idReceiver;
                $minMed;
                $count = 0;

                $currentDate = new DateTime($today);

                $query_receivers = "SELECT u.idusuario FROM usuario u WHERE u.status = 'A' AND u.tipo_usuario = 'R' AND NOT EXISTS (SELECT 1 FROM doacao d WHERE d.idreceptor = u.idusuario AND d.idalimento = ? AND d.data_doacao >= DATE(CURDATE() - 5));";
                $res = $conexao->prepare($query_receivers);
                $res->execute([$idAlimento]);

                while($data = $res->fetch(PDO::FETCH_ASSOC)){

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

                    if ($totalDonationsType == 0) {
                        $daysType = 31;
                    }

                    $total_amount = 0;
                    
                    $query_amount = "SELECT d.quantidade, a.unidade_medida FROM doacao d, alimentos a WHERE d.idalimento = a.idalimento AND d.idreceptor = ?";
                    $res_amount = $conexao->prepare($query_amount);
                    $res_amount->execute([$data['idusuario']]);

                    while($data_amount = $res_amount->fetch(PDO::FETCH_ASSOC)){

                        if ($data_amount['unidade_medida'] == 'Un') {

                            $total_amount += $data_amount['quantidade'] * 0.1;

                        } else if ($data_amount['unidade_medida'] == 'L') {

                            $total_amount += $data_amount['quantidade'] * 0.95;

                        } else {

                            $total_amount += $data_amount['quantidade'];

                        }
                    }

                    $total_amount_type = 0;
                    
                    $query_amount_type = "SELECT d.quantidade, a.unidade_medida FROM doacao d, alimentos a WHERE d.idalimento = a.idalimento AND a.idtipo = ? AND d.idreceptor = ?";
                    $res_amount_type = $conexao->prepare($query_amount_type);
                    $res_amount_type->execute([$foodType, $data['idusuario']]);

                    while($data_amount_type = $res_amount_type->fetch(PDO::FETCH_ASSOC)){

                        if ($data_amount_type['unidade_medida'] == 'Un') {

                            $total_amount_type += $data_amount_type['quantidade'] * 0.1;

                        } else if ($data_amount_type['unidade_medida'] == 'L') {

                            $total_amount_type += $data_amount_type['quantidade'] * 0.95;

                        } else {

                            $total_amount_type += $data_amount_type['quantidade'];

                        }
                    }

                    $media = ($totalDonations * 0.5) + $totalDonationsType + ($total_amount * 1.5) + ($total_amount_type * 3) - $days - ($daysType * 2);

                    if (empty($minMed) || $media < $minMed) {
                        $minMed = $media;
                        $idReceiver = $data['idusuario'];
                    }
                    $count++;
                }

                if ($count > 0) {

                    $query_donation = "INSERT INTO doacao (iddoador, idreceptor, idalimento, quantidade, data_doacao, situacao) VALUES (?, ?, ?, ?, ?, 'E')";
                    $res = $conexao->prepare($query_donation);
                    $res->execute([$userId, $idReceiver, $idAlimento, $amount, $today]);

                } else {

                    $query_update = "UPDATE alimentos SET quantidade = quantidade + ? WHERE idalimento = ?";
                    $res = $conexao->prepare($query_update);
                    $res->execute([$amount, $idAlimento]);

                    $msg = "Doação recusada e retornada ao doador!";

                }
            }

            if (!isset($idDoacao)){

                $query_update = "UPDATE alimentos SET quantidade = quantidade - ? WHERE idalimento = ?";
                $res = $conexao->prepare($query_update);
                $res->execute([$amount, $idAlimento]);

            } else {

                $query_recusado = "UPDATE doacao SET situacao = 'R' WHERE iddoacao = ?";
                $res = $conexao->prepare($query_recusado);
                $res->execute([$idDoacao]);

            }
            
        } else {
            $errors++;
            $msg = "Não é possível realizar a doação, pois não há mais receptores diponíveis.";
        }
    }

    $arr = array('errors' => $errors, 'msg' => $msg);
    echo json_encode($arr);
?>