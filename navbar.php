
   <nav class="navbar navbar-expand-lg navbar-light" id="nav">
        <div class="logo-div">
            <a class="navbar-brand" href="index.php">Food Waste</a>
        </div>
        <div class="links-div">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <?php 
                    if((!isset($_SESSION['user']) == true) and (!isset($_SESSION['password']) == true)){
                ?>
                <li class="nav-item active">
                    <a class="nav-link" id="cadastro-link" href="cadastro.php">Cadastro</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" id="login-link" href="login.php">
                        Login
                    </a>
                </li>
                <?php
                    }
                    else {
                ?>
                <div class="menu-div">
                    <button onclick="openMenu()" class="btnMenu">
                        <i class="fa fa-user"></i>
                        <?php
                        print_r($_SESSION['user']);
                        ?>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <div id="userMenu" class="menu-content">
                        <li class="nav-item">
                            <a href="logout.php" id="logout-link" class="nav-link"><i class="fa fa-arrow-right-from-bracket"></i>Sair</a>
                        </li>
                    </div>
                </div>
                <?php
                    }
                ?>
                </ul>
            </div>
        </div>
    </nav>