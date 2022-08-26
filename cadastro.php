<?php
    if(isset($_POST['submit'])){

        include_once('database.php');

        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashPw   = password_hash($password,PASSWORD_DEFAULT);
        $userType = $_POST['userType'];
        $fantasyName = $_POST['fantasyName'];
        $reason = $_POST['reason'];
        $email = $_POST['email'];
        $telephone = $_POST['tel'];
        $cnpj = $_POST['cnpj'];
        $state = $_POST['state'];
        $cep = $_POST['cep'];
        $address = $_POST['address'];
        $number = $_POST['num'];

        $query = mysqli_query($conexao, "INSERT INTO usuario (tipo_usuario, nome_usuario, senha, nome_fantasia, razao_social, email, telefone, cnpj, estado, cep, endereco, numero) 
                                         VALUES ('$userType', '$username', '$hashPw', '$fantasyName', '$reason', '$email', '$telephone', '$cnpj', '$state', '$cep', '$address', '$number')");

    }

    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/cadastroStyle.css" >
    <title>Food Waste - Cadastro</title>
</head>
<body>

<?php
    require_once("./navbar.php");
?>

    <form action="cadastro.php" method="POST">
        <h2 class="legend">Cadastrar Usuário</h2>
        
        <input type="text" name="username" placeholder="Nome de usúario" class="inputUser" >
       
        <input type="password" name="password" placeholder="Senha" class="inputUser" >
       
        <input type="password" name="confirmPassword" placeholder="Confirmar senha" class="inputUser">
        
        <div class="typeDiv">
                <input  type="radio" name="userType" id="doador" value="D" checked>
                <label  for="doador">Doador</label>
            
                <input  type="radio" name="userType" id="receptor" value="R">
                <label  for="receptor">Receptor</label>
        </div>

        <input type="text" name="fantasyName" placeholder="Nome fantasia" class="inputUser" >
        
        <input type="text" name="reason" placeholder="Razão social" class="inputUser">
       
        <input type="email" name="email" placeholder="E-mail" class="inputUser" >
       
        <input type="tel" name="tel" placeholder="Telefone" class="inputUser">

        <input type="text" name="cnpj" placeholder="CNPJ" class="inputUser" >
       
        <input type="text" name="state" placeholder="Estado" class="inputUser" >
        
        <input type="text" name="cep" placeholder="CEP" class="inputUser">     

        <input type="text" name="address" placeholder="Endereço" class="inputUser" >

        <input type="text" name="num" placeholder="Número" class="inputUser" >

        <input class="buttonform" type="submit" name="submit" value="Finalizar Cadastro">
    </form>
    
<?php
    require_once("./footer.php");
?>