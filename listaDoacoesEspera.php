<?php
session_start();
include_once('database.php');
$userId = $_SESSION['userId'];
$page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);

$sql_num_rows = "SELECT COUNT(iddoacao) as total FROM doacao WHERE idreceptor = ? AND situacao = 'E'";
$res_rows = $conexao->prepare($sql_num_rows);
$res_rows->execute([$userId]);
$rows = $res_rows->fetch(PDO::FETCH_ASSOC);
$num_rows = $rows['total'];

if (!empty($page) && $num_rows > 0){
    
    $max_rows_pg = 5;
    $first_row = ($page * $max_rows_pg) - $max_rows_pg;

    $sql = "SELECT * FROM doacao WHERE idreceptor = $userId AND situacao = 'E' ORDER BY data_doacao DESC LIMIT $first_row, $max_rows_pg";
    $res = $conexao->prepare($sql);
    $res->execute();

    $list = "<table class='table table-striped table-hover text-center align-middle'>
                <thead>
                    <tr>
                        <th scope='col'>Alimento</th>
                        <th scope='col'>Doador</th>
                        <th scope='col'>Quantidade</th>
                        <th scope='col'>Tipo de Alimento</th>
                        <th scope='col'>Data Doação</th>
                        <th scope='col'>Ações</th>
                    </tr>
                </thead>
                <tbody>";

    while($data = $res->fetch(PDO::FETCH_ASSOC)){

        $idAlimento = $data['idalimento'];
        $idDoador = $data['iddoador'];
        // $today = date('y-m-d');
        // $validity = date('y-m-d', strtotime($data['prazo_validade']));
        $dataDoacao = date('d/m/Y', strtotime($data['data_doacao']));
        $um;

        $sql_food_type = "SELECT t.descricao_alimento FROM tipo_alimento t, alimentos a WHERE idtipo_alimento = a.idtipo AND a.idalimento = $idAlimento";
        $typeRes = $conexao->prepare($sql_food_type);
        $typeRes->execute();
        $typeArray = $typeRes->fetch(PDO::FETCH_ASSOC);
        $foodType = $typeArray['descricao_alimento'];

        $sql_alimento = "SELECT descricao, unidade_medida FROM alimentos WHERE idalimento = $idAlimento";
        $resAlimento = $conexao->prepare($sql_alimento);
        $resAlimento->execute();
        $alimentoArray = $resAlimento->fetch(PDO::FETCH_ASSOC);

        $unidade_medida = $alimentoArray['unidade_medida'];
        $alimento = $alimentoArray['descricao'];

        $sql_receiver = "SELECT nome_usuario FROM usuario WHERE idusuario = $idDoador";
        $resReceiver = $conexao->prepare($sql_receiver);
        $resReceiver->execute();
        $receiverArray = $resReceiver->fetch(PDO::FETCH_ASSOC);

        $username = $receiverArray['nome_usuario'];

        switch($unidade_medida){
            case 'Un':
                if ($data['quantidade'] >= 2) {
                    $um = ' unidades';
                } else {
                    $um = ' unidade';
                }
                break;
            case 'Kg':
                $um = ' kg';
                break;
            case 'L':
                if ($data['quantidade'] >= 2) {
                    $um = ' litros';
                } else {
                    $um = ' litro';
                }
                break;
        }

        // if($validity <= $today) {

        //     $query_update = "UPDATE alimentos SET situacao = 'V' WHERE idalimento = ?";
        //     $res_update = $conexao->prepare($query_update);
        //     $res_update->execute([$data['idalimento']]);
        //     $status = 'Vencido';

        // } else if($data['quantidade'] <= 0) {

        //     $query_update = "UPDATE alimentos SET situacao = 'F' WHERE idalimento = ?";
        //     $res_update = $conexao->prepare($query_update);
        //     $res_update->execute([$data['idalimento']]);
        //     $status = 'Em falta';

        // }

        $list.= "<tr>
                    <td>".$alimento."</td>
                    <td>".$username."</td>
                    <td>".$data['quantidade'].$um."</td>
                    <td>".$foodType."</td>
                    <td>".$dataDoacao."</td>
                    <td>
                        <button class='btn btn-outline-success' value=".$data['iddoacao']." data-bs-toggle='modal' data-bs-target='#aceiteModal' onclick='novoAlimento(false,this.value)'>Aceitar</button>
                        <button class='btn btn-outline-danger' value=".$data['iddoacao']." data-bs-toggle='modal' data-bs-target='#recusaModal' onclick='novoAlimento(false,this.value)'>Recusar</button>
                    </td>
                </tr>";
    }

    $list .= "</tbody>
            </table>";

    $qtd_pages = ceil($num_rows / $max_rows_pg);
    $max_links = 2;

    $list.= "<div class='clearfix'>
                <div class='hint-text d-flex justify-content-between align-items-center'>";

    if ($num_rows < $max_rows_pg) {
        $list.= "<p>Mostrando <b>$num_rows</b> de <b>$num_rows</b> registros</p>";
    } else {
        $list.= "<p>Mostrando <b>$max_rows_pg</b> de <b>$num_rows</b> registros</p>";
    }

    $list.= "<ul class='pagination lh-1'>
                <li class='page-item'><a href='#' onclick='listarDoacoesEspera(1)' class='page-link'>Primeira</a></li>";

    for($pg_anterior = $page - $max_links; $pg_anterior <= $page - 1; $pg_anterior++){
        if($pg_anterior >= 1){
            $list.= "<li class='page-item'><a href='#' onclick='listarDoacoesEspera($pg_anterior)' class='page-link'>$pg_anterior</a></li>";
        }
    }

    $list.= "<li class='page-item active'><a href='#' class='page-link'>$page</a></li>";

    for($pg_posterior = $page + 1; $pg_posterior <= $page + $max_links; $pg_posterior++){
        if($pg_posterior <= $qtd_pages){
            $list.= "<li class='page-item'><a href='#' onclick='listarDoacoesEspera($pg_posterior)' class='page-link'>$pg_posterior</a></li>";
        }
    }

    $list.= "<li class='page-item'><a href='#' onclick='listarDoacoesEspera($qtd_pages)' class='page-link'>Última</a></li>
          </ul>
        </div>
      </div>";

    echo $list;
} else {
    echo "<div class='alert alert-secondary bg-transparent border-0' role='alert'>
            <div class='d-flex flex-column justify-content-center text-center'>
                <i class='fa-solid fa-magnifying-glass fs-4 p-1'></i>
                Nenhuma doação encontrada.
            </div>
          </div>";
}
?>