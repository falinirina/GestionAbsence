<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        if (isset($_POST['nomDepartement']))
        {
            require_once "config.php";
            $nom = htmlspecialchars($_POST['nomDepartement']);
            $check = $bdd->query("SELECT * FROM departement WHERE nomDepartement='$nom'");
            $check = $check->rowCount();
            if ($check == 0)
            {
                $insert = $bdd->query("INSERT INTO departement(nomDepartement) VALUE ('$nom')");
                echo "done";
            }
        } else echo "existe";
    }

?>