<?php
    require_once("./template.php");
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
        <h1 class="legend">Login</h1>
      
        <div>
            <i class="bi bi-person-fill login-icon"></i>
            <input class="inputUser" type="text" name="user" placeholder="Usuário" tabindex=1 required>
        </div>

        <div>
            <i class="bi bi-lock-fill login-icon"></i>
            <input class="inputUser" type="password" name="password" placeholder="Senha" tabindex=2 required>
            <div class="forgot-div">
                <a href="" class="linkPw">Esqueceu sua senha?</a>
            </div>
        </div>

        <input class="buttonform" type="submit" name="submit" value="Entrar">

    </form>
</div>

</body>
</html>