<?php
session_start();

try {
    if(isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['password'])){

        include_once('database.php');

        $user = $_POST['user'];
        $password = $_POST['password'];

        $sql_rows = "SELECT count(*) FROM usuario WHERE nome_usuario = :user"; 
        $res_rows = $conexao->prepare($sql_rows); 
        $res_rows->bindParam(':user', $user);
        $res_rows->execute(); 
        $count = $res_rows->fetchColumn();

        if($count < 1) {
            session_unset();
            $msg = "Usuário não encontrado!";
            header('Location: login.php?msg='.$msg);
        } else {
            $queryDados = "SELECT nome_usuario, senha, idusuario, tipo_usuario FROM usuario WHERE nome_usuario = :user";
            $res = $conexao->prepare($queryDados);
            $res->bindParam(':user', $user);
            $res->execute();
            $data = $res->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($password, $data['senha'])) {
                $_SESSION['user'] = $user;
                $_SESSION['password'] = $password;

                $_SESSION['userId'] = $data['idusuario'];
                $_SESSION['userType'] = $data['tipo_usuario'];

                header('Location: index.php');
            }
            else {
                session_unset();
                $msg = "Usuário ou senha incorretos!";
                header('Location: login.php?msg='.$msg);
            }
        }

    }
    else{
        session_unset();
        header('Location: login.php');
    }
} catch (PDOException $e) {
    session_unset();
    $msg = "Erro: ". $e->getMessage();
    header('Location: login.php?msg='.$msg);
}

?>