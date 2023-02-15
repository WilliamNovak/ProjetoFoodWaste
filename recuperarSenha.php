<?php
    include_once('database.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // Verifica se o formulário foi enviado
    if (isset($_POST['email'])) {
        // Verifica se o endereço de e-mail está registrado

        $email = $_POST['email'];
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            $token = bin2hex(random_bytes(32));

            $stmt = $conn->prepare("UPDATE usuario SET token_senha = :token WHERE email = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Envia o e-mail com o link de recuperação de senha
            $mail = new PHPMailer;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'foodwastemail@gmail.com';
            $mail->Password = 'FoodWaste123';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('foodwastemail@gmail.com', 'Food Waste');
            $mail->addAddress($email);
            $mail->Port = 587;
            $mail->Subject = 'Recuperação de senha';
            $link = "http://localhost/projetofoodwaste/recuperarSenha.php?token=$token&email=$email";
            $mail->Body = "Clique no link para recuperar sua senha: $link";

            if (!$mail->send()){ 
                echo 'Ocorreu um erro ao enviar o e-mail de recuperação de senha';
            } else {
                echo 'Um e-mail de recuperação de senha foi enviado para o seu endereço de e-mail';
            }
        } 
    else {
        echo 'Este endereço de e-mail não está registrado em nosso sistema';
    }
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
        <form action="testaLogin.php" method="POST">
            <h1 class="legend">
                <img src="imgs/LogoPequena.png" alt="Login Logo" class="login-logo">
            </h1>
            <h1>EMail de recuperar</h1>
            <div class="input-div">
                <span class="fa fa-user login-icon"></span>
                <input class="inputs" type="email" name="email" placeholder="E-mail" tabindex=1 required>
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