<?php
    require_once("./template.php");

    session_start();
    if((isset($_SESSION['user']) == true) and (isset($_SESSION['password']) == true)){
        header('Location: index.php');
    }

    if(isset($_POST['cnpj'])){

        include_once('database.php');

        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashPw   = password_hash($password,PASSWORD_DEFAULT);
        $userType = $_POST['userType'];
        $fantasyName = $_POST['fantasyName'];
        $reason = $_POST['reason'];
        $email = $_POST['email'];
        $telephone = preg_replace("/[^0-9]/", "", $_POST['tel']);
        $cnpj = preg_replace("/[^0-9]/", "", $_POST['cnpj']);
        $state = $_POST['state'];
        $city = $_POST['city'];
        $cep = preg_replace("/[^0-9]/", "", $_POST['cep']);
        $district = $_POST['district'];
        $street = $_POST['street'];
        $number = $_POST['num'];

        $query = "INSERT INTO usuario (tipo_usuario, nome_usuario, senha, nome_fantasia, razao_social, email, telefone, cnpj, estado, cidade, cep, bairro, rua, numero) 
                       VALUES (:usertype, :username, :pw, :fantasyname, :reason, :email, :tel, :cnpj, :uf, :city, :cep, :district, :street, :num)";
        $res = $conexao->prepare($query);
        $res->execute(array(":usertype" => $userType, ":username" => $username, ":pw" => $hashPw, ":fantasyname" => $fantasyName, ":reason" => $reason, ":email" => $email, ":tel" => $telephone, ":cnpj" => $cnpj, ":uf" => $state, ":city" => $city, ":cep" => $cep, ":district" => $district, ":street" => $street, ":num" => $number));
        // or die(
        //     "<script language='javascript' type='text/javascript'>
        //         alert('Erro cadastrar usuário!');
        //         window.location.href='cadastro.php';
        //     </script>"
        // );

        header("Location: login.php");
        
    }
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/cadastroStyle.css" >
    <title>Food Waste - Cadastro</title>
</head>
<body>

<?php
    require_once("./navbar.php");
?>
    <div class="divBody">
    <form action="cadastro.php" method="POST" id="formCadastro">
        <div class="container">
            <h2 class="legend">Cadastrar Usuário</h2>

            <div class="row">
                <div class="col-md-6 divcadastro">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <input type="text" name="username" id="username" placeholder="Nome de usúario" class="inputs mx-auto" required>
                            </div>
                            <div class="row">
                                <div id="user_error" class="error_msg">Nome de usuário já está sendo utilizado</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <input type="password" name="password" placeholder="Senha" class="inputs mx-auto" id="pw1" required>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <input type="password" name="confirmPassword" placeholder="Confirmar senha" class="inputs mx-auto"  id="pw2" required>
                            </div>
                            <div class="row">
                                <div id="pwError" class="error_msg">As senhas não são compatíveis</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" class="inputs mx-auto" required>
                            </div>
                            <div class="row">
                                <div id="error_cnpj" class="error_msg">CNPJ inválido ou já cadastrado!</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <input type="text" name="fantasyName" id="fantasyName" placeholder="Nome fantasia" class="inputs mx-auto" required>
                    </div>
                
                    <div class="row">
                        <input type="text" name="reason" id="reason" placeholder="Razão social" class="inputs mx-auto" required>
                    </div>
                </div>
                
                <div class="col-md-6 divcadastro">
                    <div class="row mx-auto">
                        <div class="col-md-6">
                            <input type="radio" name="userType" class="btn-check toggle toggle-left" id="doador" autocomplete="off" value="D" checked>
                            <label for="doador" class="btn btn-outline-success labelType w-100">Doador</label>
                        </div>

                        <div class="col-md-6">
                            <input type="radio" name="userType" class="btn-check toggle toggle-right" id="receptor" value="R">
                            <label for="receptor" class="btn btn-outline-success labelType w-100">Receptor</label>
                        </div>
                    </div>

                    <div class="row">
                        <input type="email" name="email" id="email" placeholder="E-mail" class="inputs mx-auto" required>
                    </div>
                    <div class="row">
                        <div id="email_error" class="error_msg">Endereço de email já cadastrado</div>
                    </div>
            
                    <div class="row">
                        <input type="tel" name="tel" id="tel" placeholder="Telefone" class="inputs mx-auto" maxlength="15" required>
                    </div>
                    <div class="row">
                        <div id="tel_error" class="error_msg">Número de telefone já cadastrado</div>
                    </div>

                    <div class="row">
                        <input type="text" name="cep" id="cep" onblur="pesquisacep(this.value);" placeholder="CEP" class="inputs mx-auto" maxlength="9" required>
                    </div>
                    <div class="row">
                        <div id="error_cepE" class="error_msg">CEP não encontrado</div>
                    </div>
                    <div class="row">
                        <div id="error_cepI" class="error_msg">Formato de CEP inválido</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row d-flex justify-content-end">
                                <input type="text" name="city" id="city" placeholder="Cidade" class="inputs" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <input type="text" name="district" id="district" placeholder="Bairro" class="inputs" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row d-flex justify-content-end">
                                <input type="text" id="street" name="street" placeholder="Rua" class="inputs">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="row">
                                <select name="state" id="state" class="inputs inputUf" required>
                                    <option value="" selected>UF</option>
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
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <input type="number" name="num" id="num" placeholder="Número" class="inputs" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="buttonform" type="button" onclick="validaForm()" name="btnSubmit" id="btnSubmit">Finalizar Cadastro</button>
        </div>
    </form>
    </div>
    
    <script src="js/cadastroScript.js"></script>
<?php
    require_once("./footer.php");
?>