<?php

    session_start();
    if((!isset($_SESSION['user']) == true) and (!isset($_SESSION['password']) == true)){
        session_unset();
    }
    else{
        $loged = $_SESSION['user'];
        echo $_SESSION['userType'] . ' - ' . $_SESSION['userId'];
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

<script src="js/script.js"></script>

<?php
    require_once("./footer.php");
?>