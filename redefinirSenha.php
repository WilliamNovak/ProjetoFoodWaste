<?php
    include_once('database.php');

    // recuperando o token e o e-mail do usuário do banco de dados
    if (isset($_POST['senha'])) {
        $token = $_GET['token'];
        $sql = "SELECT * FROM usuario WHERE token = :token";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $senha = $_POST['senha'];
            $confirmaSenha = $_POST['confirmaSenha'];
            if ($senha === $confirmaSenha) {
              $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
              $sql = "UPDATE usuario SET senha = :senha, token = NULL WHERE id = :id";
              $stmt = $conexao->prepare($sql);
              $stmt->bindValue(':senha', $senhaHash);
              $stmt->bindValue(':id', $usuario['id']);
              if ($stmt->execute()) {
                header('Location: login.php');
                exit();
              } else {
                $mensagem = "Erro ao atualizar a senha. Tente novamente mais tarde.";
              }
            } else {
              $mensagem = "As senhas digitadas não conferem.";
            }
          }
        } else {
          $mensagem = "Token inválido.";
        }
      } else {
        $mensagem = "Token não encontrado.";
      }
    
    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

    if(isset($_GET['msg'])) {
        echo "<script> alert('{$_GET['msg']}'); </script>";
    }
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
            <h1>Verificar token</h1>
            <div class="input-div">
                <span class="fa fa-user login-icon"></span>
                <input class="inputs" type="password" name="senha" placeholder="Senha" tabindex=1 required>
                <input class="inputs" type="password" name="confirmaSenha" placeholder="Insira novamente" tabindex=1 required>
            </div>
            <input class="buttonform" type="submit" name="submit" value="Entrar" tabindex=3>
        </form>
    </div>

</body>

</html>