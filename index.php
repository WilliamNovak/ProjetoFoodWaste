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
        <p class="text-start crs-content fs-3">Teste slide sobre inseguranca alimentar</p>
      </div>
    </div>
    <div class="carousel-item crs dark-div">
      <img src="imgs/desperdicio" class="d-block w-100 dark-img" alt="Imagem desperdício de alimentos">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-start crs-content fs-1">Desperdício de Alimentos</h2>
        <p class="text-start crs-content fs-3">Teste slide sobre desperdicio de alimentos</p>
      </div>
    </div>
    <div class="carousel-item crs dark-div">
      <img src="imgs/lei_img" class="d-block w-100 dark-img crs-lei" alt="Imagem sobre lei">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-start crs-content fs-1">Lei nº 14.016/20</h2>
        <p class="text-start crs-content fs-3">Teste slide sobre lei nº 14.016/20</p>
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

<div class="div-objetivos">
    <div class="objetivos">
        <div class="propag">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Vero, voluptatibus doloremque consequuntur eum, nostrum sunt nihil officia non 
        </div>

        <div class="propag">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam sapiente, earum beatae labore veritatis hic molestias laboriosam aspernatur 
        </div>

        <div class="propag">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa similique maxime asperiores officia consectetur sequi at! Illum voluptatem nulla, voluptates, 
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