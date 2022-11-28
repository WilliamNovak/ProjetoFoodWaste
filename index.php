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
<div id="carouselExampleIndicators" class="carousel slide banner " data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active crs">
      <p class="textBanner">Teste1</p>
      <img src="imgs/inseguranca_alimentar" class="imgBanner">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <p>Teste3</p>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <p>Teste4</p>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
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