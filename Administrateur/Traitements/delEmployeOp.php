<?php
    if (isset($_POST['employe']) && isset($_POST['password']) && isset($_POST['user']))
    {
        $id = htmlspecialchars($_POST['employe']);
        $password = htmlspecialchars($_POST['password']);
        $username = htmlspecialchars($_POST['user']);

        // Operation delete
        require_once "config.php";
        $result = $bdd->query("SELECT password, typeCompte FROM employe WHERE username='$username'");
        $result = $result->fetch();
        $password = hash('sha256', $password);
        
        if ($result['password'] == $password)
        {
            if ($result['typeCompte'] == "admin")
            {
                $info = $bdd->query("SELECT photoEmploye FROM employe WHERE idEmploye='$id'");
                $info = $info->fetch();
                $bdd->query("DELETE FROM employe WHERE idEmploye='$id'");
        
                $file = "../../Photos".$info['photoEmploye'];
                unlink($file);
            }
        }

    }

?>