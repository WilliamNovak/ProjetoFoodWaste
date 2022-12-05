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

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#foodModal">
    <i class="fa-solid fa-plus"></i> 
    Cadastrar Alimento
  </button>

  <div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="foodModalLabel">Cadastrar Alimento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i> 
          </button>
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

  <div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Alimento</th>
          <th scope="col">Tipo de Alimento</th>
          <th scope="col">Prazo de Validade</th>
          <th scope="col">Quantidade</th>
          <th scope="col">Situação</th>
          <th scope="col">Doação</th>
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
            echo "<td><button class='btn btn-outline-success' value=".$data['idalimento'].">Doar</button></td>";
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="./js/alimentosScript.js"></script>
<?php
    require_once("./footer.php");
?>