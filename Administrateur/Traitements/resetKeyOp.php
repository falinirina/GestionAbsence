<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
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
                    $info = $bdd->query("SELECT username FROM employe WHERE idEmploye='$id'");
                    $info = $info->fetch();
                    $newpass = hash('sha256', $info['username']);
                    $bdd->query("UPDATE employe SET password='$newpass' WHERE idEmploye='$id'");
                    
                    echo "done";
                }
            }
        }
    }

?>