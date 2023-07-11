<?php
    session_start();
    if(!isset($_SESSION['utilisateur'])) header("Location:../");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Styles/Semantic_UI/semantic.css">
    <link rel="stylesheet" href="Styles/time.css">
    <?php
        echo '<link rel="stylesheet" href="Styles/home.css">'."\n";
        if (isset($_SESSION['infoUtilisateur']['darkMode']))
        {
            if ($_SESSION['infoUtilisateur']['darkMode']) echo '<link rel="stylesheet" href="Styles/dark.css">'."\n";
            else echo '<link rel="stylesheet" href="Styles/light.css">'."\n";
        }
    ?>
    <script src="../Jquery/jquery.js"></script>
    <title>Bienvenue: </title>
</head>
<body>
    <style>
        
    </style>
    <div id="contenue">
        <?php
            include "Pages/home.php";
        ?>
    </div>
</body>
</html>