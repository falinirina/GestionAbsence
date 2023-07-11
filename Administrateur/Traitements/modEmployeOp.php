<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe'])
        && isset($_POST['id']) && isset($_POST['adresse']) && isset($_POST['numero']) 
        && isset($_POST['embauche']) && isset($_POST['departement']))
        {
            require_once "config.php";
            $getData = array(
                'id' => htmlspecialchars($_POST['id']),
                'nom' => htmlspecialchars($_POST['nom']),
                'prenom' => htmlspecialchars($_POST['prenom']),
                'sexe' => htmlspecialchars($_POST['sexe']),
                'adresse' => htmlspecialchars($_POST['adresse']),
                'numero' => htmlspecialchars($_POST['numero']),
                'embauche' => htmlspecialchars($_POST['embauche']),
                'departement' => htmlspecialchars($_POST['departement'])
            );
            $check = $bdd->query("SELECT * FROM employe WHERE (nomEmploye='".$getData["nom"]."' AND prenomEmploye='".$getData["prenom"]."' AND sexeEmploye='".$getData["sexe"]."')");
            $check = $check->rowCount();
            if ($check == 0)
            {
                if (isset($_FILES['img']))
                {
                    $username = $bdd->query("SELECT username FROM employe WHERE idEmploye=".$getData['id']);
                    $username = $username->fetch();
                    $username = $username[0];
                    $files = "p_".date("djY_hisa")."-".$username.".jpg";
                } else {
                    if ($getData['sexe'] == 'M')
                    {
                        $files = "user-profile.png";
                    } else {
                        $files = "user-profile-woman.png";
                    }
                }

                $update = $bdd->prepare("UPDATE employe SET nomEmploye=:nom, prenomEmploye=:prenom,sexeEmploye=:sexe, adresseEmploye=:adresse, numeroEmploye=:numero, dateDEmbauche=:embauche, departEmploye=:departement, photoEmploye=:photo WHERE idEmploye=".$getData['id']);
                $res = $update->execute(array(
                    'nom'=>$getData['nom'],
                    'prenom'=>$getData['prenom'],
                    'sexe'=> $getData['sexe'],
                    'adresse'=>$getData['adresse'],
                    'numero'=>$getData['numero'],
                    'embauche'=>$getData['embauche'],
                    'departement'=>$getData['departement'],
                    'photo'=>$files
                ));
                if ($res) {
                    if (isset($_FILES['img']))
                    {
                        $target_dir = "../../Photos/";
                        $target_file = $target_dir . $files;
                        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
                    }
                    echo "done";
                }
            } else if ($check == 1)
            {
                if (isset($_FILES['img']))
                {
                    $username = $bdd->query("SELECT username FROM employe WHERE idEmploye=".$getData['id']);
                    $username = $username->fetch();
                    $username = $username[0];
                    $files = "p_".date("djY_hisa")."-".$username.".jpg";
                } else {
                    if ($getData['sexe'] == 'M')
                    {
                        $files = "user-profile.png";
                    } else {
                        $files = "user-profile-woman.png";
                    }
                }

                $update = $bdd->prepare("UPDATE employe SET adresseEmploye=:adresse, numeroEmploye=:numero, dateDEmbauche=:embauche, departEmploye=:departement, photoEmploye=:photo WHERE idEmploye=".$getData['id']);
                $res = $update->execute(array(
                    'adresse'=>$getData['adresse'],
                    'numero'=>$getData['numero'],
                    'embauche'=>$getData['embauche'],
                    'departement'=>$getData['departement'],
                    'photo'=>$files
                ));
                if ($res) {
                    if (isset($_FILES['img']))
                    {
                        $target_dir = "../../Photos/";
                        $target_file = $target_dir . $files;
                        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
                    }
                    echo "done";
                }
            }
            // var_dump($_POST);
    
        } else if (isset($_POST['id']) && isset($_FILES['img']))
        {
            require_once "./config.php";
            $getData = array(
                'id' => htmlspecialchars($_POST['id'])
            );
            $username = $bdd->query("SELECT username FROM employe WHERE idEmploye=".$getData['id']);
            $username = $username->fetch();
            $username = $username[0];
            $files = "p_".date("djY_hisa")."-".$username.".jpg";
            $update = $bdd->prepare("UPDATE employe SET photoEmploye=:photo WHERE idEmploye=".$getData['id']);
            $res = $update->execute(array(
                'photo'=>$files
            ));
            if ($res) {
                $target_dir = "../../Photos/";
                $target_file = $target_dir . $files;
                move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
                echo "done";
            }
        }
    }


?>