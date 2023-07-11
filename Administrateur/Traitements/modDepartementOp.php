<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['nom']) && isset($_POST['id']))
    {
        require_once './config.php';
        $nom = htmlspecialchars($_POST['nom']);
        $id = (int)htmlspecialchars($_POST['id']);
        $check = $bdd->query("SELECT * FROM departement WHERE nomDepartement='$nom'");
        $check = $check->rowCount();

        if ($check == 0)
        {
            $update = $bdd->query("UPDATE departement SET nomDepartement='$nom' WHERE idDepartement=$id");
            if ($update)
            {
                echo "done";
            } else {
                echo "erreur";
            }
        } else {
            echo "existe";
        }
    }

?>