<?php
    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

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
        $city = $_POST['city'];
        $cep = $_POST['cep'];
        $address = $_POST['address'];
        $number = $_POST['num'];

        $query = mysqli_query($conexao, "INSERT INTO usuario (tipo_usuario, nome_usuario, senha, nome_fantasia, razao_social, email, telefone, cnpj, estado, cidade, cep, endereco, numero) 
                                            VALUES ('$userType', '$username', '$hashPw', '$fantasyName', '$reason', '$email', '$telephone', '$cnpj', '$state', '$city', '$cep', '$address', '$number')");

        header("Location: login.php");
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

    <div class="cadastro-div">
        <form action="cadastro.php" method="POST">
            <h2 class="legend">Cadastrar Usuário</h2>

            <div class="columns-div">
                <div class="column1">
                    <input type="text" name="username" id="username" placeholder="Nome de usúario" class="inputs" required>
                
                    <input type="password" name="password" placeholder="Senha" class="inputs" id="pw1" required>
                    <div class="pw-error" id="errPw1"></div>

                    <input type="password" name="confirmPassword" placeholder="Confirmar senha" class="inputs"  id="pw2" required>
                    <div class="pw-error" id="errPw2"></div>

                    <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" class="inputs" required>
                    <div id="error_cnpj" class="error_msg">CNPJ inválido!</div>

                    <input type="text" name="fantasyName" id="fantasyName" placeholder="Nome fantasia" class="inputs" required>
                
                    <input type="text" name="reason" id="reason" placeholder="Razão social" class="inputs" required>
                </div>
                
                <div class="column2">
                    <div class="typeDiv">
                        <input type="radio" name="userType" class="toggle toggle-left" id="doador" value="D" checked>
                        <label for="doador" class="labelType">Doador</label>
                    
                        <input type="radio" name="userType" class="toggle toggle-right" id="receptor" value="R">
                        <label for="receptor" class="labelType">Receptor</label>
                    </div>

                    <input type="email" name="email" id="email" placeholder="E-mail" class="inputs" required>
            
                    <input type="tel" name="tel" id="tel" placeholder="Telefone" class="inputs" required>
                    
                    <div class="flex-div">
                        <input type="text" name="cep" id="cep" placeholder="CEP" class="inputs firstInput" required>
                        
                        <select name="state" id="state" class="inputs secondInput" required>
                            <option value="" selected hidden>Estado</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RR">RR</option>
                            <option value="RO">RO</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>

                    <input type="text" name="city" id="city" placeholder="Cidade" class="inputs" required>

                    <div class="flex-div">
                        <input type="text" name="address" id="address" placeholder="Endereço" class="inputs firstInput" required>

                        <input type="number" name="num" id="num" placeholder="Número" class="inputs secondInput" required>
                    </div>

                </div>
            </div>

            <button class="buttonform" type="submit" name="submit" id="btnSubmit">Finalizar Cadastro</button>
        </form>
    </div>
    
    <script src="js/cadastroScript.js"></script>
<?php
    require_once("./footer.php");
?>