<?php
session_start();
include_once('database.php');
$userId = $_SESSION['userId'];
$page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);

if (!empty($page)){

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
        $um;

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

        $list.= "<tr>
                    <td>".$data['descricao']."</td>
                    <td>".$foodType."</td>
                    <td>".$data['prazo_validade']."</td>
                    <td>".$data['quantidade'].$um."</td>
                    <td>".$data['situacao']."</td>
                    <td>
                        <button class='btn btn-outline-dark' value=".$data['idalimento']." data-bs-toggle='modal' data-bs-target='#foodModal' onclick='novoAlimento(false,this.value)'>Editar</button>
                        <button class='btn btn-outline-success' value=".$data['idalimento'].">Doar</button>
                        <button class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#deleteModal' value=".$data['idalimento']." onclick='setaIdExcluir(this.value)'>Excluir</button>
                    </td>
                </tr>";
    }

    $list .= "</tbody>
            </table>";

    $sql_num_rows = "SELECT COUNT(idalimento) as total FROM alimentos WHERE idproprietario = ?";
    $res_rows = $conexao->prepare($sql_num_rows);
    $res_rows->execute([$userId]);
    $rows = $res_rows->fetch(PDO::FETCH_ASSOC);
    $num_rows = $rows['total'];

    $qtd_pages = ceil($num_rows / $max_rows_pg);
    $max_links = 2;

    $list.= "<div class='clearfix'>
                <div class='hint-text d-flex justify-content-between align-items-center'>
                    <p>Mostrando <b>$max_rows_pg</b> de <b>$num_rows</b> registros</p>
                    <ul class='pagination lh-1'>
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
    echo "<div class='alert alert-secondary' role='alert'>
            A simple secondary alert—check it out!
          </div>";
}
?>