<?php

// echo "here";
    if(isset($_POST['aPass']) && isset($_POST['nPass']) && isset($_POST['cPass']))
    {
        // echo "here";
        session_start();
        if(isset($_SESSION['utilisateur']))
        {
            $employe = $_SESSION['infoUtilisateur']['id'];
            $aPass=htmlspecialchars($_POST['aPass']);
            $nPass=htmlspecialchars($_POST['nPass']);
            $cPass=htmlspecialchars($_POST['cPass']);
            // echo "here";

            if($aPass!=""&&$nPass!=""&&$cPass!="")
            {
                // echo "here";
                if($nPass == $cPass)
                {
                    if($cPass != $aPass)
                    {
                        require_once "../../Administrateur/Traitements/config.php";
                        $getpass=$bdd->query("SELECT password FROM employe WHERE idEmploye='$employe'");
                        $getpass=$getpass->fetch();
                        $getpass=$getpass['password'];
                        $aPass = hash('sha256',$aPass);
                        if($aPass == $getpass)
                        {
                            $cPass = hash('sha256',$cPass);
                            $bdd->query("UPDATE employe SET password='$cPass' WHERE idEmploye='$employe'");
                            echo "done";
                        }
                    }
                }
            }
        }
    }

?>