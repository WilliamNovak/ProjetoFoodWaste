<?php
    session_start();

    include_once('database.php');
    $userId = $_SESSION['userId'];

    if(isset($_POST['food'])){

      $food = $_POST['food'];
      $foodType = $_POST['foodType'];
      $amount = $_POST['amount'];
      $validity = $_POST['validity'];

      $query = mysqli_query($conexao, "INSERT INTO alimentos (idproprietario, idtipo, descricao, prazo_validade, quantidade, situacao)
                                            VALUES ('$userId', '$foodType', '$food', '$validity', '$amount', 'E')");

    }

    $sql = "SELECT * FROM alimentos WHERE idproprietario = '$userId' ORDER BY prazo_validade ASC";

    $res = $conexao->query($sql);

    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/alimentosStyle.css">
    <title>Food Waste - Alimentos</title>
</head>
<body>
<?php
    require_once("./navbar.php");
?>

  <div class="container text-start fs-6">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Alimentos</h2>
          </div>
          <div class="col-sm-6 text-end">
            <button type="button" class="btn btn-success mt-1" data-bs-toggle="modal" data-bs-target="#foodModal">
              <i class="fa-solid fa-plus"></i> 
              Cadastrar Alimento
            </button>
          </div>
        </div>
      </div>
      <table class="table table-striped table-hover text-center align-middle">
        <thead>
          <tr>
            <th scope="col">Alimento</th>
            <th scope="col">Tipo de Alimento</th>
            <th scope="col">Prazo de Validade</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Situação</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>

        <tbody>
          <?php
            while($data = mysqli_fetch_array($res)){

              $typeId = $data['idtipo'];
              $sql_food_type = "SELECT descricao_alimento FROM tipo_alimento WHERE idtipo_alimento = '$typeId'";
              $typeRes = $conexao->query($sql_food_type);
              while($typeData = mysqli_fetch_array($typeRes)){
                $foodType = $typeData['descricao_alimento'];
              }

              echo "<tr>";
              echo "<td>".$data['descricao']."</td>";
              echo "<td>".$foodType."</td>";
              echo "<td>".$data['prazo_validade']."</td>";
              echo "<td>".$data['quantidade']."</td>";
              echo "<td>".$data['situacao']."</td>";
              echo "<td>
                      <button class='btn btn-outline-dark' value=".$data['idalimento'].">Editar</button>
                      <button class='btn btn-outline-success' value=".$data['idalimento'].">Doar</button>
                      <button class='btn btn-outline-danger' value=".$data['idalimento'].">Excluir</button>
                    </td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
      <div class="clearfix">
        <div class="hint-text d-flex justify-content-between">
          <p>Showing <b>5</b> out of <b>100</b> entries</p>
          <ul class="pagination lh-1">
            <li class="page-item disabled"><a href="#" class="page-link">Previous</a></li>
            <li class="page-item"><a href="#" class="page-link">1</a></li>
            <li class="page-item"><a href="#" class="page-link">2</a></li>
            <li class="page-item active"><a href="#" class="page-link">3</a></li>
            <li class="page-item"><a href="#" class="page-link">4</a></li>
            <li class="page-item"><a href="#" class="page-link">5</a></li>
            <li class="page-item"><a href="#" class="page-link">Next</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="foodModalLabel">Cadastro de Alimento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="alimentos.php" method="POST" id="foodForm">
            <div class="flex-container">
              <div class="flex-child">
                <input type="text" class="inputs" name="food" placeholder="Alimento" required>
              </div>

              <div class="flex-child">
                <select name="foodType" class="inputs foodTypeInput" placeholder="Tipo de alimento" required>
                  <option value="" selected>Tipo de alimento</option>
                  <option value="1">Cereais, pães e tubérculos</option>
                  <option value="2">Hortaliças</option>
                  <option value="3">Frutas</option>
                  <option value="4">Leguminosas</option>
                  <option value="5">Carnes e ovos</option>
                  <option value="6">Leite e derivados</option>
                  <option value="7">Óleos e gorduras</option>
                  <option value="8">Açúcares e doces</option>
                  <option value="9">Bebidas</option>
                </select>
              </div>
            </div>

            <div class="flex-container">
              <div class="flex-child">
                <input type="number" class="inputs" name="amount" placeholder="Quantidade" min="1" max="1000" required>
              </div>

              <div class="flex-child">
                <input type="date" class="inputs" name="validity" placeholder="Validade" required>
              </div>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa-solid fa-chevron-left"></i> 
            Voltar
          </button>
          <button type="submit" form="foodForm" class="btn btnFormat">
            <i class="fa-solid fa-plus"></i> 
            Adicionar
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/alimentosScript.js"></script>
<?php
    require_once("./footer.php");
?>