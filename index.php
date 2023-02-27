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
<body class="homePage">
<?php
    require_once("./navbar.php"); 
?>

<div id="carouselRegion" class="carousel slide banner" data-bs-interval="10000" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselRegion" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active crs">
      <img src="imgs/inseguranca_alimentar" class="d-block w-100 dark-img crs-inseguranca" alt="Imagem insegurança alimentar">
      <div class="carousel-caption d-md-block">
        <h2 class="text-start crs-content fs-1">Insegurança Alimentar</h2>
        <p class="text-start crs-content fs-3">10,3 milhões de brasileiros sofriam com insegurança alimentar em 2018, segundo IBGE. Aumento de 41,5% em relação a 2013.</p>
      </div>
    </div>
    <div class="carousel-item crs">
      <img src="imgs/desperdicio" class="d-block w-100 dark-img crs-desperdicio" alt="Imagem desperdício de alimentos">
      <div class="carousel-caption d-md-block">
        <h2 class="text-start crs-content fs-1">Desperdício de Alimentos</h2>
        <p class="text-start crs-content fs-3">Cerca de 17% a um terço da produção diária de alimentos no mundo acaba como desperdício, segundo a FAO. 13% dos alimentos descartados são do comércio.</p>
      </div>
    </div>
    <div class="carousel-item crs">
      <img src="imgs/lei_img" class="d-block w-100 dark-img crs-lei" alt="Imagem sobre lei">
      <div class="carousel-caption d-md-block">
        <h2 class="text-start crs-content fs-1">Lei nº 14.016/20</h2>
        <p class="text-start crs-content fs-3">A Lei nº 14.016, de 23 de junho de 2020, dispõe sobre o combate ao desperdício de alimentos e a doação de excedentes de alimentos para o consumo humano. </p>
      </div>
    </div>
    <div class="carousel-item crs">
      <img src="imgs/algorithm_img" class="d-block w-100 dark-img crs-algorithm" alt="Imagem algoritmo">
      <div class="carousel-caption d-md-block">
        <h2 class="text-start crs-content fs-1">Algoritmo</h2>
        <p class="text-start crs-content fs-3">Trabalhamos com a tecnologia para redirecionar doações de alimentos de forma proporcional e igualitária, através de um algoritmo que realiza o encaminhamento das doações de forma automatizada.</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev z-min" type="button" data-bs-target="#carouselRegion" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>

  <button class="carousel-control-next z-min" type="button" data-bs-target="#carouselRegion" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  
</div>

<div class="row row-cols-1 m-auto mt-4 justify-content-center">

  <div class="row row-cols-2 p-4 mx-3 justify-content-around align-content-center who-div">
    <div class="row row-cols-1 px-5 info">
      <h2 id="whoTitle" class="info-title">Quem somos?</h2>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, quibusdam eum, molestiae minus nihil, animi maiores iste delectus sint rerum ut natus officiis molestias. Magnam iusto fuga earum asperiores nobis?</p>
    </div>
    <div class="row row-cols-1 py-4">
      <div class="row row-cols-3 justify-content-around align-content-center">
        <div class="row justify-content-center align-content-center circle-div">
          <img src="imgs/william.jpg" alt="" class="circle">
        </div>
        <div class="row justify-content-center align-content-center circle-div">
          <img src="imgs/lazaro.png" alt="" class="circle">
        </div>
        <div class="row justify-content-center align-content-center circle-div">
          <img src="imgs/dionatan.png" alt="" class="circle">
        </div>
      </div>
    </div>
  </div>
  
  <div class="row row-cols-2 justify-content-around align-content-center p-3 mx-3">
    <div class="row row-cols-1 py-4">
      <div class="row row-cols-3 justify-content-around align-content-center">
        <div class="row justify-content-center align-content-center icon-circle">
          <i class="fa-solid fa-apple-whole icon"></i>
        </div>
        <div class="row justify-content-center align-content-center icon-circle">
          <i class="fa-solid fa-trash-can icon"></i>
        </div>
        <div class="row justify-content-center align-content-center icon-circle">
          <i class="fa-solid fa-hand-holding-heart icon"></i>
        </div>
      </div>
    </div>
    <div class="row row-cols-1 px-5 info">
      <h2 id="whatTitle" class="info-title">O que fazemos?</h2>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, quibusdam eum, molestiae minus nihil, animi maiores iste delectus sint rerum ut natus officiis molestias. Magnam iusto fuga earum asperiores nobis?</p>
    </div>
  </div>

  <div class="row row-cols-1 pb-3 justify-content-center">
    <div class="row row-cols-1 div-fluxo justify-content-center">
      <h2>Como funciona?</h2>
      <div class="row row-cols-1 justify-content-center">
        <img src="imgs/fluxo.svg" class="fluxo">
      </div>
    </div>
  </div>
  
  <div class="row row-cols-2 justify-content-around align-items-center p-4 mx-3 mb-4">
    <div class="row row-cols-1 px-5 info">
      <h2 id="whyTitle" class="info-title">Por que fazemos?</h2>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, quibusdam eum, molestiae minus nihil, animi maiores iste delectus sint rerum ut natus officiis molestias. Magnam iusto fuga earum asperiores nobis?</p>
    </div>
    <div class="row row-cols-1 d-flex justify-content-center">
      <img src="imgs/fluxo_algoritmo.png" alt="" class="img-algorithm">
    </div>
  </div>
</div>

<footer class="footer"></footer>

<?php
    require_once("./footer.php");
?>