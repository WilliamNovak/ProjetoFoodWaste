<?php
    session_start();
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
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa-solid fa-chevron-left"></i> 
            Voltar
          </button>
          <button type="button" class="btn btnFormat">
            <i class="fa-solid fa-plus"></i> 
            Adicionar
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="./js/alimentosScript.js"></script>
<?php
    require_once("./footer.php");
?>