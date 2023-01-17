<?php
    header('Content-Type: application/json');
    include_once('database.php');

    $idAlimento = $_POST['id'];

    $data = "SELECT * FROM alimentos WHERE idalimento = $idAlimento";
    $res = $conexao->prepare($data);
    $res->execute();

    while($data = $res->fetch(PDO::FETCH_ASSOC)){
        $idTipo = $data['idtipo'];
        $descricao = $data['descricao'];
        $validade = $data['prazo_validade'];
        $quantidade = $data['quantidade'];
        $um = $data['unidade_medida'];
    }

    $arr = array('id' => $idAlimento, 'tipo' => $idTipo, 'descricao' => $descricao, 'validade' => $validade, 'quantidade' => $quantidade, 'unidade' => $um);
    echo json_encode($arr);
?>