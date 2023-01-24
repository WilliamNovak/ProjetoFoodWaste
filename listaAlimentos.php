<?php
session_start();
include_once('database.php');
$userId = $_SESSION['userId'];
$page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);

$sql_num_rows = "SELECT COUNT(idalimento) as total FROM alimentos WHERE idproprietario = ?";
$res_rows = $conexao->prepare($sql_num_rows);
$res_rows->execute([$userId]);
$rows = $res_rows->fetch(PDO::FETCH_ASSOC);
$num_rows = $rows['total'];

if (!empty($page) && $num_rows > 0){

    $max_rows_pg = 5;
    $first_row = ($page * $max_rows_pg) - $max_rows_pg;

    $sql = "SELECT * FROM alimentos WHERE idproprietario = $userId ORDER BY prazo_validade ASC LIMIT $first_row, $max_rows_pg";
    $res = $conexao->prepare($sql);
    $res->execute();

    $list = "<table class='table table-striped table-hover text-center align-middle'>
                <thead>
                    <tr>
                        <th scope='col'>Alimento</th>
                        <th scope='col'>Tipo de Alimento</th>
                        <th scope='col'>Prazo de Validade</th>
                        <th scope='col'>Quantidade</th>
                        <th scope='col'>Situação</th>
                        <th scope='col'>Ações</th>
                    </tr>
                </thead>
                <tbody>";

    while($data = $res->fetch(PDO::FETCH_ASSOC)){

        $typeId = $data['idtipo'];
        $today = date('y-m-d');
        $validity = date('y-m-d', strtotime($data['prazo_validade']));
        $dataValidade = date('d/m/Y', strtotime($data['prazo_validade']));
        $um;
        $status;

        $sql_food_type = "SELECT descricao_alimento FROM tipo_alimento WHERE idtipo_alimento = $typeId";
        $typeRes = $conexao->prepare($sql_food_type);
        $typeRes->execute();
        $typeArray = $typeRes->fetch(PDO::FETCH_ASSOC);
        $foodType = $typeArray['descricao_alimento'];

        switch($data['unidade_medida']){
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

        switch($data['situacao']){
            case 'E':
                $status = 'Em estoque';
                break;
            case 'F':
                $status = 'Em falta';
                break;
            case 'V':
                $status = 'Vencido';
                break;
        }

        if($validity <= $today) {

            $query_update = "UPDATE alimentos SET situacao = 'V' WHERE idalimento = ?";
            $res_update = $conexao->prepare($query_update);
            $res_update->execute([$data['idalimento']]);
            $status = 'Vencido';

        } else if($data['quantidade'] <= 0) {

            $query_update = "UPDATE alimentos SET situacao = 'F' WHERE idalimento = ?";
            $res_update = $conexao->prepare($query_update);
            $res_update->execute([$data['idalimento']]);
            $status = 'Em falta';

        }

        $list.= "<tr>
                    <td>".$data['descricao']."</td>
                    <td>".$foodType."</td>
                    <td>".$dataValidade."</td>
                    <td>".$data['quantidade'].$um."</td>
                    <td>".$status."</td>
                    <td>
                        <button class='btn btn-outline-dark' value=".$data['idalimento']." data-bs-toggle='modal' data-bs-target='#foodModal' onclick='novoAlimento(false,this.value)'>Editar</button>";

        if($data['situacao'] == 'V' || $validity <= $today || $data['quantidade'] <= 0){
            $list.= "<button class='btn btn-outline-success mx-1' data-bs-toggle='modal' data-bs-target='#donateModal' value=".$data['idalimento']." disabled onclick='setaDoacao(this.value)'>Doar</button>";
        } else {
            $list.= "<button class='btn btn-outline-success mx-1' data-bs-toggle='modal' data-bs-target='#donateModal' value=".$data['idalimento']." onclick='setaDoacao(this.value)'>Doar</button>";
        }
                        
        $list.= "<button class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#deleteModal' value=".$data['idalimento']." onclick='setaIdExcluir(this.value)'>Excluir</button>
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
                <li class='page-item'><a href='#' onclick='listarAlimentos(1)' class='page-link'>Primeira</a></li>";
    
    for($pg_anterior = $page - $max_links; $pg_anterior <= $page - 1; $pg_anterior++){
        if($pg_anterior >= 1){
            $list.= "<li class='page-item'><a href='#' onclick='listarAlimentos($pg_anterior)' class='page-link'>$pg_anterior</a></li>";
        }
    }

    $list.= "<li class='page-item active'><a href='#' class='page-link'>$page</a></li>";

    for($pg_posterior = $page + 1; $pg_posterior <= $page + $max_links; $pg_posterior++){
        if($pg_posterior <= $qtd_pages){
            $list.= "<li class='page-item'><a href='#' onclick='listarAlimentos($pg_posterior)' class='page-link'>$pg_posterior</a></li>";
        }
    }

    $list.= "<li class='page-item'><a href='#' onclick='listarAlimentos($qtd_pages)' class='page-link'>Última</a></li>
          </ul>
        </div>
      </div>";

    echo $list;
} else {
    echo "<div class='alert alert-secondary bg-transparent border-0' role='alert'>
            <div class='d-flex flex-column justify-content-center text-center'>
                <i class='fa-solid fa-magnifying-glass fs-4 p-1'></i>
                Nenhum alimento encontrado.
            </div>
          </div>";
}
?>