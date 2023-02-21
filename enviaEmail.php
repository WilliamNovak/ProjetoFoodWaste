<?php
    include_once('database.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $errors = 0;
    $msg =  "";

    // Verifica se o endereço de e-mail está registrado
    $email = $_POST['email'];
    $stmt = $conexao->prepare("SELECT idusuario FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        $token = bin2hex(random_bytes(5));
        $stmt = $conexao->prepare("UPDATE usuario SET token_senha = :token WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Envia o e-mail com o link de recuperação de senha
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'foodwastemail@gmail.com';
        $mail->Password = 'wqqjjiqjljbyhqlx';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('foodwastemail@gmail.com', 'Food Waste');
        $mail->addAddress($email);
        $mail->Subject = 'Recuperação de senha';
        $mail->Body = "Utilize esse token para recuperar a senha: $token";

        if (!$mail->send()){ 
            $errors++;
            $msg = 'Ocorreu um erro ao enviar o e-mail de recuperação de senha'.$mail->ErrorInfo;
        }
    } 
    else {
        $errors++;
        $msg = 'Este endereço de e-mail não está registrado em nosso sistema';
    }

    $arr = array('errors' => $errors, 'msg' => $msg);
    echo json_encode($arr);
?>