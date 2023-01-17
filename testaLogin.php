<?php
session_start();

if(isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['password'])){

    include_once('database.php');

    $user = $_POST['user'];
    $password = $_POST['password'];

    $sql_rows = "SELECT count(*) FROM usuario WHERE nome_usuario = ?"; 
    $res_rows = $conexao->prepare($sql_rows); 
    $res_rows->execute([$user]); 
    $count = $res_rows->fetchColumn(); 

    // or die("<script language='javascript' type='text/javascript'>
    //             alert('Erro interno de login: Contate o suporte!');
    //             window.location.href='login.php';
    //         </script>");

    if($count < 1)
    {
        session_unset();
        $msg = "Usuário não encontrado!";
        header('Location: login.php?msg='.$msg);
    }
    else{
        $queryDados = "SELECT nome_usuario, senha FROM usuario WHERE nome_usuario = ?";
        $res = $conexao->prepare($queryDados);
        $res->execute([$user]);
        $data = $res->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $data['senha'])) {
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $password;

            $query = "SELECT idusuario, tipo_usuario FROM usuario WHERE nome_usuario = ?";
            $userRes = $conexao->prepare($query);
            $userRes->execute([$user]);
            $row = $userRes->fetch(PDO::FETCH_ASSOC);

            $_SESSION['userId'] = $row['idusuario'];
            $_SESSION['userType'] = $row['tipo_usuario'];

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

?>