<?php
    session_start();
    require_once("./template.php");
    $error = "";

    if (isset($_GET['msg'])){
        $error = $_GET['msg'];
    }
?>
<link rel="stylesheet" type="text/css" href="styles/error.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Oops!</h1>
        <div class="content">
            <span>Erro - Contate o suporte</span>
            <p><?php echo $error ?></p>
            <button onclick="window.location.href='index.php'">Ir para página Home</button>
        </div>
    </div>

<?php
    require_once("./footer.php");
?>