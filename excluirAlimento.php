<?php
    session_start();
    include_once('database.php');

    $idAlimento = $_POST['id'];
    $errors = 0;
    $msg = "";

    $query = "SELECT COUNT(*) as total FROM doacao WHERE idalimento = ?";
    $res = $conexao->prepare($query);
    $res->execute([$idAlimento]);
    $resArray = $res->fetch(PDO::FETCH_ASSOC);
    $totalDonations = $resArray['total'];

    if ($totalDonations > 0) {
        $errors++;
        $msg = "Já existem doações desse alimento, não é possível realizar a exclusão!";
    } else {
        $query = "DELETE FROM alimentos WHERE idalimento = ?";
        $res = $conexao->prepare($query);
        $res->execute([$idAlimento]);
        // or die(
        //     "<script language='javascript' type='text/javascript'>
        //         alert('Erro ao excluir alimento!');
        //         window.location.href='alimentos.php';
        //     </script>"
        // );

        $msg = "Alimento excluído com sucesso!";
    }

    $arr = array('errors' => $errors, 'msg' => $msg);
    echo json_encode($arr);
?>