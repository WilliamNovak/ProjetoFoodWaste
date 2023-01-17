<?php
session_start();
include_once('database.php');
$userId = $_SESSION['userId'];
$page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);

if (!empty($page)){

    $max_rows_pg = 10;
    $first_row = ($page * $max_rows_pg) - $max_rows_pg;

    $sql = "SELECT * FROM alimentos WHERE idproprietario = '$userId' ORDER BY prazo_validade ASC LIMIT $first_row, $max_rows_pg";
    $res = $conexao->query($sql);

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

    while($data = mysqli_fetch_array($res)){

        $typeId = $data['idtipo'];
        $um;

        $sql_food_type = "SELECT descricao_alimento FROM tipo_alimento WHERE idtipo_alimento = '$typeId'";
        $typeRes = $conexao->query($sql_food_type);

        while($typeData = mysqli_fetch_array($typeRes)){
            $foodType = $typeData['descricao_alimento'];
        }

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

    $list.= "<div class='clearfix'>
                <div class='hint-text d-flex justify-content-between'>
                    <p>Showing <b>5</b> out of <b>100</b> entries</p>
                    <ul class='pagination lh-1'>
                        <li class='page-item disabled'><a href='#' class='page-link'>Previous</a></li>
                        <li class='page-item'><a href='#' class='page-link'>1</a></li>
                        <li class='page-item'><a href='#' class='page-link'>2</a></li>
                        <li class='page-item active'><a href='#' class='page-link'>3</a></li>
                        <li class='page-item'><a href='#' class='page-link'>4</a></li>
                        <li class='page-item'><a href='#' class='page-link'>5</a></li>
                        <li class='page-item'><a href='#' class='page-link'>Next</a></li>
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