<?php
    session_start();
    include_once('database.php');

    $idAlimento = $_POST['id'];

    $query = mysqli_query($conexao, "DELETE FROM alimentos WHERE idalimento = '$idAlimento'") or die(
        "<script language='javascript' type='text/javascript'>
            alert('Erro ao excluir alimento!');
            window.location.href='alimentos.php';
        </script>"
    );

    echo json_encode('excluiu');
?>