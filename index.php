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

<h2>FOOD WASTE</h2>


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
            Dionantan Jocemar de Souza de Lima
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