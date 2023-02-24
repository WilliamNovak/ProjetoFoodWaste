
   <nav class="navbar navbar-expand-lg navbar-light" id="nav">
        <div class="logo-div">
            <a class="navbar-brand" href="index.php">
                <img src="imgs/navLogo.png" alt="Food Waste Logo" class="nav-logo">
            </a>
        </div>
        <div class="links-div">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <div class="home-links">
                        <li class="nav-item active">
                            <a class="nav-link" id="login-link" href="#whoTitle">Quem somos?</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" id="login-link" href="#whatTitle">O que fazemos?</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" id="login-link" href="#whyTitle">Por que fazemos?</a>
                        </li>
                    </div>

                    <?php 
                        if((!isset($_SESSION['user']) == true) and (!isset($_SESSION['password']) == true)){
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" id="cadastro-link" href="cadastro.php">Cadastro</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" id="login-link" href="login.php">Login</a>
                    </li>

                    <?php
                        } else {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" id="chartsLink" href="charts.php">Dashboard</a>
                    </li>

                    <?php
                            if($_SESSION['userType'] == "D"){
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" id="doacaoLinkD" href="doacoes.php">Doações</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" id="alimento-link" href="alimentos.php">Alimentos</a>
                    </li>

                    <?php
                            } else {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" id="doacaoLinkR" href="doacoesReceptor.php">Doações</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" id="doacaoEsperaLink" href="doacoesEspera.php">Disponível</a>
                    </li>
                    <?php
                            }
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            <?php
                                print_r($_SESSION['user']);
                            ?>
                        </a>
                        <ul class="dropdown-menu menu-content">
                            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-arrow-right-from-bracket"></i>Sair</a></li>
                        </ul>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>