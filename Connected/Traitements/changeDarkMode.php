<?php
    session_start();
    if (isset($_SESSION['utilisateur']) && isset($_POST['dark']))
    {
        require_once "../../Administrateur/Traitements/config.php";
        $darkMode = htmlspecialchars($_POST['dark']);
        $username = $_SESSION['utilisateur'];
        $check = $bdd->query("SELECT idEmploye FROM employe WHERE username='$username'");
        $check = $check->rowCount();
        if ($check == 1)
        {
            if ($darkMode == "on")
            {
                $bdd->query("UPDATE employe SET darkMode='on' WHERE username='$username'");
                $_SESSION['infoUtilisateur']['darkMode'] = true;
            } else if ($darkMode == "off")
            {
                $bdd->query("UPDATE employe SET darkMode='off' WHERE username='$username'");
                $_SESSION['infoUtilisateur']['darkMode'] = false;
            }
        }
    }

?>