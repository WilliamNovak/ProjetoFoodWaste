<?php
    include_once('database.php');

    if (isset($_POST['token'])) {
        $token = $_POST['token'];
        echo $token;

        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE token_senha = ?");
        $stmt->execute([$token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
    
            header('Location: redefinirSenha.php?token=' . $token);
            exit;
        } else {
            echo 'Token não encontrado';
        }
    }

    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

    if(isset($_GET['msg'])) {
        echo "<script> alert('{$_GET['msg']}'); </script>";
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
                <span class="fa fa-user login-icon"></span>
                <input class="inputs" type="text" name="token" placeholder="Token" tabindex=1 required>
            </div>
            <input class="buttonform" type="submit" name="submit" value="Entrar" tabindex=3>
        </form>
    </div>

<?php
    require_once("./footer.php");
?>