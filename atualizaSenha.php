<?php
    include_once('database.php');
    $errors = 0;
    $msg = "Senha alterada com sucesso!";

    // recuperando o token e o e-mail do usuário do banco de dados
    if (isset($_POST['token'])) {
        $token = $_POST['token'];

        $sql = "SELECT * FROM usuario WHERE token_senha = :token";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {

            $pw1 = $_POST['password'];
            $pw2 = $_POST['confirmPassword'];

            if ($pw1 === $pw2) {

                $pwHash = password_hash($pw1, PASSWORD_DEFAULT);

                $sql = "UPDATE usuario SET senha = :senha, token_senha = NULL WHERE idusuario = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindValue(':senha', $pwHash);
                $stmt->bindValue(':id', $usuario['idusuario']);

                if (!$stmt->execute()) {
                    $errors++;
                    $msg = "Erro ao atualizar a senha. Tente novamente mais tarde.";
                }

            } else {
                $errors++;
                $msg = "As senhas digitadas não conferem.";
            }

        } else {
            $errors++;
            $msg = "Token inválido.";
        }
        
    } else {
        $errors++;
        $msg = "Token não encontrado.";
    }

    $arr = array('errors' => $errors, 'msg' => $msg);
    echo json_encode($arr);
?>