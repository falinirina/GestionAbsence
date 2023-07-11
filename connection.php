<?php
    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        
        if($password != '' && $password != '')
        {
            require_once "Administrateur/Traitements/config.php";
            $employe = $bdd->query("SELECT * FROM employe WHERE username='".$username."'");
            $row = $employe->rowCount();
            if ($row == 1)
            {
                $employe = $employe->fetch();
                $password=hash('sha256',$password);
                
                if ($employe['password'] == $password)
                {
                    if ($employe['typeCompte'] == "admin")
                    {
                        session_start();
                        $_SESSION['administrateur'] = $employe['username'];
                        if($employe['darkMode'] == "off") { $_SESSION["darkMode"]=false; } else { $_SESSION["darkMode"]=true; }
                        header("Location:Administrateur/");
                        
                    } else {
                        session_start();
                        if ($employe["darkMode"] == "on")
                        {
                            $darkMode = true;
                        } else {
                            $darkMode = false;
                        }
                        $_SESSION['utilisateur'] = $employe["username"];
                        $_SESSION['infoUtilisateur'] = array(
                            'id'=> $employe['idEmploye'],
                            'nom'=> $employe['nomEmploye'],
                            'prenom'=> $employe['prenomEmploye'],
                            'photo'=> $employe['photoEmploye'],
                            'adresse'=> $employe['adresseEmploye'],
                            'sexe'=> $employe['sexeEmploye'],
                            'darkMode'=>$darkMode
                        );
                        if($employe['darkMode'] == "off") { $_SESSION["darkMode"]=false; } else { $_SESSION["darkMode"]=true; }
                        header("Location:Connected/");
                    }
                } else {
                    header("Location:./?err=verif&us=$username");
                }
            } else {
                header("Location:./?err=verif");
            }
        } else {
            header("Location:./?err=vide");
        }
    } else {
        header("Location:./");
    }

?>