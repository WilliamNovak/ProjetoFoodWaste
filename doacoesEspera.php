<?php
    session_start();
    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/doacoesStyle.css">
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
            <h2>Doações Recebidas</h2>
          </div>
        </div>
      </div>
      <span class="receiver-list"></span>
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