<?php
    include_once('database.php');

    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

    require_once("./template.php");
?>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
<title>Food Waste - Login</title>
</head>

<body>
    <?php
        require_once("./navbar.php");
    ?>

    <div class="login-div">
        <form action="" method="POST">
            <h1 class="legend">
                <img src="imgs/LogoPequena.png" alt="Login Logo" class="login-logo">
            </h1>
            <h2 class="legend fs-1">E-mail de recuperação</h2>
            <div class="input-div">
                <span class="fa fa-user login-icon"></span>
                <input class="inputs" type="email" id="email" name="email" placeholder="E-mail" tabindex=1 required>
            </div>
            <button class="buttonform" type="button" name="submit" onclick="validaEnvioEmail()" tabindex=3>Enviar Token</button>
        </form>
    </div>

    <div id="errorAlert" class="alert alert-danger position-absolute" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation bi flex-shrink-0 me-3 ms-1 fs-4"></i>
            <div id="alertMsg"></div>
        </div>
    </div>
    
    <script src="js/password.js"></script>

<?php
    require_once("./footer.php");
?>