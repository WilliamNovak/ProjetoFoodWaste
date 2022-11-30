<?php

    session_start();
    if((!isset($_SESSION['user']) == true) and (!isset($_SESSION['password']) == true)){
        session_unset();
    }
    else{
        $loged = $_SESSION['user'];
    }

    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/homeStyle.css" >
    <title>Food Waste</title>
</head>
<body>
<?php
    require_once("./navbar.php"); 
?>
<div id="carouselRegion" class="carousel slide banner" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active crs dark-div">
      <img src="imgs/inseguranca_alimentar" class="d-block w-100 dark-img crs-inseguranca" alt="Imagem insegurança alimentar">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-start crs-content fs-1">Insegurança Alimentar</h2>
        <p class="text-start crs-content fs-3">10,3 milhões de brasileiros sofriam com insegurança alimentar em 2018, segundo IBGE. Aumento de 41,5% em relação a 2013.</p>
      </div>
    </div>
    <div class="carousel-item crs dark-div">
      <img src="imgs/desperdicio" class="d-block w-100 dark-img" alt="Imagem desperdício de alimentos">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-start crs-content fs-1">Desperdício de Alimentos</h2>
        <p class="text-start crs-content fs-3">Cerca de 17% a um terço da produção diária de alimentos no mundo acaba como desperdício, segundo a FAO. 13% dos alimentos descartados são do comércio.</p>
      </div>
    </div>
    <div class="carousel-item crs dark-div">
      <img src="imgs/lei_img" class="d-block w-100 dark-img crs-lei" alt="Imagem sobre lei">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-start crs-content fs-1">Lei nº 14.016/20</h2>
        <p class="text-start crs-content fs-3">A Lei nº 14.016, de 23 de junho de 2020, dispõe sobre o combate ao desperdício de alimentos e a doação de excedentes de alimentos para o consumo humano. </p>
      </div>
    </div>
    <div class="carousel-item crs dark-div">
      <img src="imgs/algorithm_img" class="d-block w-100 dark-img crs-algorithm" alt="Imagem algoritmo">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-start crs-content fs-1">Algoritmo</h2>
        <p class="text-start crs-content fs-3">Teste slide sobre algoritmo</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselRegion" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselRegion" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  
</div>

<div class="row row-cols-1 row-cols-md-3 g-4 w-75 m-auto mb-4">
  <div class="col d-flex justify-content-center">
  <div class="card border-success border-1 mb-3 w-100 h-100" style="max-width: 18rem;">
      <div class="card-header">Quem somos?</div>
      <div class="card-body text-success">
        <h5 class="card-title">Success card title</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
    </div>
  </div>
  <div class="col d-flex justify-content-center">
    <div class="card border-success border-1 mb-3 w-100 h-100" style="max-width: 18rem;">
      <div class="card-header">O que fazemos?</div>
      <div class="card-body text-success">
        <h5 class="card-title">Success card title</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
    </div>
  </div>
  <div class="col d-flex justify-content-center">
    <div class="card border-success border-1 mb-3 w-100 h-100" style="max-width: 18rem;">
      <div class="card-header">Por que fazemos?</div>
      <div class="card-body text-success">
        <h5 class="card-title">Success card title</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
    </div>
  </div>
</div>

<h2>COMO FUNCIONA?</h2>

<img src="imgs/teste.svg" class="fluxo">

<div class="div-ceos">
    <div class="ceos">
        <div class="card">
            Dionatan Jocemar de Souza de Lima
        </div>
        
        <div class="card">
            Lázaro Engel Fernandes
        </div>

        <div class="card">
            William Renan Novak
        </div>
    </div>
</div>

<script src="js/script.js"></script>

<?php
    require_once("./footer.php");
?>