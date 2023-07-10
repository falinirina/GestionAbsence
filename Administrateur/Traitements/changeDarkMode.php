<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['dark']))
    {
        require_once "config.php";
        $darkMode = htmlspecialchars($_POST['dark']);
        $username = $_SESSION['administrateur'];
        $check = $bdd->query("SELECT idEmploye FROM employe WHERE username='$username'");
        $check = $check->rowCount();
        if ($check == 1)
        {
            if ($darkMode == "on")
            {
                $bdd->query("UPDATE employe SET darkMode='on' WHERE username='$username'");
                $_SESSION["darkMode"] = true;
            } else if ($darkMode == "off")
            {
                $bdd->query("UPDATE employe SET darkMode='off' WHERE username='$username'");
                $_SESSION["darkMode"] = false;
            }
        }
    }

?>