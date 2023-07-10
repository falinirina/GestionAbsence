<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['id']))
    {
        $id = htmlspecialchars($_POST['id']);
        require_once "./config.php";
        $check = $bdd->query("SELECT username FROM employe WHERE departEmploye=$id");
        $check = $check->rowCount();
        if ($check == 0)
        {
            $bdd->query("DELETE FROM departement WHERE idDepartement=$id");
            echo "done";
        } else {
            echo "employe";
        }
    }



?>