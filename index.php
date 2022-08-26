<?php
    session_start();
    //print_r($_SESSION);
    if((!isset($_SESSION['user']) == true) and (!isset($_SESSION['password']) == true)){
        unset($_SESSION['user']);
        unset($_SESSION['password']);
    }
    else{
        $loged = $_SESSION['user'];
    }

    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/homeStyle.css" >
    <title>Food Waste</title>
</head>
<body>
<?php
    require_once("./navbar.php"); 
?>


<?php
    require_once("./footer.php");
?>