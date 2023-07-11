<?php 
    session_start(); 
    if(!isset($_SESSION['administrateur']))
    {
        header("Location:../");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/Semantic_UI/semantic.css">
    <link rel="stylesheet" href="../Styles/W3/w3.css">
    <link rel="stylesheet" href="../Styles/W3/w3-theme-teal.css">
    <link rel="stylesheet" href="Styles/admin.css">
    <link rel="stylesheet" href="Styles/retard.css">
    <link rel="shortcut icon" href="../logo.png" type="image/x-icon">
    <?php
        if (isset($_SESSION['darkMode']))
        {
            if ($_SESSION['darkMode'] == "on"){echo '<link rel="stylesheet" href="Styles/dark.css">'."\n";}
            else{echo '<link rel="stylesheet" href="Styles/light.css">'."\n";}
        }
    ?>
    <link rel="stylesheet" href="Styles/employes.css">
    <title>Administrateur</title>
</head>
<body>
    <script src="../Jquery/jquery.js"></script>
    <?php include "Pages/navigation.php" ?>
    <div id="contenue">
        <?php
            require_once "Pages/employes.php";
            // var_dump($_SESSION);
        ?>
    </div>
</body>
</html>