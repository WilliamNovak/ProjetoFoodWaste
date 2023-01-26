<?php
    session_start();
    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/doacoesStyle.css">
    <title>Food Waste - Doações</title>
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
            <h2>Doações</h2>
          </div>
        </div>
      </div>
      <span class="donations-list"></span>
    </div>
  </div>

  <script src="./js/doacoesReceptorScript.js"></script>
<?php
    require_once("./footer.php");
?>