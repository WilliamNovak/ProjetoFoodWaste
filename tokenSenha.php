<?php
    include_once('database.php');

    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

    if (isset($_POST['token'])) {
        $token = $_POST['token'];

        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE token_senha = ?");
        $stmt->execute([$token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            header('Location: redefinirSenha.php?token=' . $token);
        } else {
            echo '<script type="text/javascript">';
            echo '  document.addEventListener("DOMContentLoaded", function() {

                        document.getElementById("alertMsg").innerHTML = "Token inválido!";

                        $("#errorAlert").fadeIn("fast", function(){
                            $(this).show();
                        });
                        setTimeout(function(){
                            $("#errorAlert").fadeOut("slow", function(){
                                $(this).hide();
                            });
                        }, 3000);
                    });';
            echo '</script>';
        }
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
            <h2 class="legend fs-1">Verificar token</h2>
            <div class="input-div">
                <span class="fa-solid fa-key login-icon"></span>
                <input class="inputs" type="text" name="token" placeholder="Token" tabindex=1 required>
            </div>
            <input class="buttonform" type="submit" name="submit" value="Verificar" tabindex=3>
        </form>
    </div>

    <div id="errorAlert" class="alert alert-danger position-absolute" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation bi flex-shrink-0 me-3 ms-1 fs-4"></i>
            <div id="alertMsg"></div>
        </div>
    </div>

<?php
    require_once("./footer.php");
?>