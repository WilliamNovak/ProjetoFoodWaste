<?php
    session_start();
    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <title>Food Waste - Recebido</title>
</head>
<body>
<?php
    require_once("./navbar.php");
?>

  <div class="container text-start fs-6 d-flex flex-column justify-content-center" style="height: 85vh;">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Doações Disponíveis</h2>
          </div>
        </div>
      </div>
      <span class="receiver-list"></span>
    </div>
  </div>

  <div class="modal" id="acceptModal" tabindex="-1">
    <div class="modal-dialog" style="width: 500px;">
      <div class="modal-content text-start fs-6">
        <div class="modal-header">
          <h5 class="modal-title">Aceitar doação</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Deseja aceitar o recebimento dessa doação?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-chevron-left"></i> 
            Voltar
          </button>
          <button type="button" class="btn btn-success" onclick="acceptDonation()">
            <i class="fa-solid fa-check"></i>
            Aceitar
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="refuseModal" tabindex="-1">
    <div class="modal-dialog" style="width: 500px;">
      <div class="modal-content text-start fs-6">
        <div class="modal-header">
          <h5 class="modal-title">Recusar doação</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Deseja mesmo recusar o recebimento dessa doação?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-chevron-left"></i> 
            Voltar
          </button>
          <button type="button" class="btn btn-danger" onclick="refuseDonation()">
            <i class="fa-solid fa-x"></i>
            Recusar
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="errorAlert" class="alert alert-danger position-absolute" role="alert">
    <div class="d-flex align-items-center">
      <i class="fa-solid fa-triangle-exclamation bi flex-shrink-0 me-3 ms-1 fs-4"></i>
      <div id="alertMsg"></div>
    </div>
  </div>

  <div id="successAlert" class="alert alert-success position-absolute" role="alert">
    <div class="d-flex align-items-center">
      <i class="fa-solid fa-circle-check bi flex-shrink-0 me-3 ms-1 fs-4"></i>
      <div id="successMsg"></div>
    </div>
  </div>

  <script src="./js/doacoesEsperaScript.js"></script>
<?php
    require_once("./footer.php");
?>