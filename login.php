<?php
    require_once("./template.php");

    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

    if(isset($_GET['msg'])) {
        echo "<script> alert('{$_GET['msg']}'); </script>";
    }
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/loginStyle.css" >
    <title>Food Waste - Login</title>
</head>
<body>

<?php
    require_once("./navbar.php");
?>

<div class="login-div">
    <form action="testaLogin.php" method="POST">
        <h1 class="legend">
            <img src="imgs/LogoPequena.png" alt="Login Logo" class="login-logo">
        </h1>
      
        <div class="input-div">
            <span class="fa fa-user login-icon"></span>
            <input class="inputs" type="text" name="user" placeholder="Usuário" tabindex=1 required>
        </div>

        <div class="input-div">
            <i class="fa fa-key login-icon"></i>
            <input class="inputs" type="password" name="password" placeholder="Senha" tabindex=2 required>
        </div>

        <div class="forgot-div">
            <a href="./recuperarSenha.php" class="linkPw">Esqueceu sua senha?</a>
        </div>

        <input class="buttonform" type="submit" name="submit" value="Entrar" tabindex=3>

        <div class="newAccount-div">
            <p class="newAccountText">Não possui conta?</p>
            <a href="cadastro.php" class="newAccountLink">Cadastre-se</a>
        </div>

    </form>
</div>

</body>
</html>