<?php
    session_start();
    include_once('database.php');

    $idAlimento = $_POST['id'];

    $query = "DELETE FROM alimentos WHERE idalimento = ?";
    $res = $conexao->prepare($query);
    $res->execute([$idAlimento]);
    // or die(
    //     "<script language='javascript' type='text/javascript'>
    //         alert('Erro ao excluir alimento!');
    //         window.location.href='alimentos.php';
    //     </script>"
    // );

    echo json_encode('excluiu');
?>