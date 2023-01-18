<?php
    session_start();
    $request = md5(implode($_POST));

    include_once('database.php');
    $userId = $_SESSION['userId'];

    if(!isset($_SESSION['last_request']) || $_SESSION['last_request'] != $request) {
      $_SESSION['last_request'] = $request;

      if (isset($_POST['food'])) {

        $food = $_POST['food'];
        $foodType = $_POST['foodType'];
        $amount = $_POST['amount'];
        $unit = $_POST['unit'];
        $validity = $_POST['validity'];

        if (isset($_POST['id']) && !empty($_POST['id'])) {
          $foodId = $_POST['id'];

          $query = "UPDATE alimentos SET idtipo = ?, descricao = ?, prazo_validade = ?, quantidade = ?, unidade_medida = ? WHERE idalimento = ?";
          $res = $conexao->prepare($query);
          $res->execute([$foodType, $food, $validity, $amount, $unit, $foodId]);

        } else {
          $query = "INSERT INTO alimentos (idproprietario, idtipo, descricao, prazo_validade, quantidade, unidade_medida, situacao) VALUES (?, ?, ?, ?, ?, ?, 'E')";
          $res = $conexao->prepare($query);
          $res->execute([$userId, $foodType, $food, $validity, $amount, $unit]);
        }

      }
    }

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

  <div class="container text-start fs-6 d-flex flex-column justify-content-center">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Alimentos</h2>
          </div>
          <div class="col-sm-6 text-end">
            <button type="button" class="btn btn-success mt-1" data-bs-toggle="modal" data-bs-target="#foodModal" onclick="novoAlimento(true)">
              <i class="fa-solid fa-plus"></i> 
              Cadastrar Alimento
            </button>
          </div>
        </div>
      </div>
      <span class="food-list"></span>
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
              <input type="number" class="inputs d-none" name="id" placeholder="id" id="foodId">

              <div class="flex-child">
                <input type="text" class="inputs" name="food" id="foodDesc" placeholder="Alimento" required>
              </div>

              <div class="flex-child">
                <select name="foodType" id="foodType" class="inputs foodTypeInput" placeholder="Tipo de alimento" onchange="setUnit(this.value)" required>
                  <option value="" selected>Tipo de alimento</option>
                  <option value="1">Cereais, pães e tubérculos</option>
                  <option value="2">Hortaliças</option>
                  <option value="3">Frutas</option>
                  <option value="4">Leguminosas</option>
                  <option value="5">Carnes</option>
                  <option value="6">Ovos e derivados do leite</option>
                  <option value="7">Leite e bebidas lácteas</option>
                  <option value="8">Óleos e gorduras</option>
                  <option value="9">Açúcares e doces</option>
                  <option value="10">Bebidas</option>
                </select>
              </div>
            </div>

            <div class="flex-container">
              <div class="flex-child d-flex justify-content-center">
                <input type="number" class="inputs amount-input" name="amount" id="amount" placeholder="Quantidade" min="1" max="1000" required>
                <input type="text" class="inputs unit-input text-center" id="unit" name="unit" placeholder="UM" readonly="true" required>
              </div>

              <div class="flex-child">
                <input type="date" max="9999-12-31" class="inputs" name="validity" id="validity" placeholder="Validade" required>
              </div>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa-solid fa-chevron-left"></i> 
            Voltar
          </button>
          <button type="submit" id="addButton" form="foodForm" class="btn btnFormat">
            <i class="fa-solid fa-plus"></i> 
            Adicionar
          </button>
          <button type="submit" id="saveButton" form="foodForm" class="btn btnFormat">
            <i class="fa fa-save"></i> 
            Salvar Alterações
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content text-start fs-6">
        <div class="modal-header">
          <h5 class="modal-title">Excluir alimento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Deseja mesmo excluir este alimento?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-chevron-left"></i> 
            Voltar
          </button>
          <button type="button" class="btn btn-danger" onclick="excluiAlimento()">
            <i class="fa fa-trash"></i> 
            Excluir
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/alimentosScript.js"></script>
<?php
    require_once("./footer.php");
?>