<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['numero']) && isset($_POST['sexe']) && isset($_POST['departement']) && isset($_POST['embauche']))
        {
            $getData = array(
                "nom" => htmlspecialchars($_POST['nom']),
                "prenom" => htmlspecialchars($_POST['prenom']),
                "adresse" => htmlspecialchars($_POST['adresse']),
                "numero" => htmlspecialchars($_POST['numero']),
                "sexe" => htmlspecialchars($_POST['sexe']),
                "departement" => htmlspecialchars($_POST['departement']),
                "embauche" => htmlspecialchars($_POST['embauche'])
            );
            
            if (strlen($getData['nom']) > 4 && strlen($getData['adresse']) > 10 && strlen($getData['numero']) >= 10)
            {
                require_once  'config.php';
                
                $data = $bdd->query("SELECT * FROM employe WHERE (nomEmploye='".$getData["nom"]."' AND prenomEmploye='".$getData["prenom"]."' AND sexeEmploye='".$getData["sexe"]."')");
                $row = $data->rowCount();
                
                
                if ($row == 0)
                {
                    // Creation Username
                    if (strlen($getData['prenom']) == 0)
                    {
                        $username = strtolower((explode(" ", $getData['nom']))[0]);
                    } else {
                        $username = strtolower($getData['prenom'][0]).strtolower((explode(" ", $getData['nom']))[0]);
                    } 
                    // Verification Username et Creation Mot de Passe
                    $condition = array(
                        "stop" => false,
                        "count" => 0
                    );
                    while ($condition['stop'] == false)
                    {
                        $check = $bdd->query("SELECT username FROM employe WHERE username='$username'");
                        $check = $check->rowCount();
                        if ($check == 0) { $condition['stop'] = true; }
                        else { 
                            $condition['count']++;
                            $username = $username."_".($condition['count']);
                        }
                    }
                    
                    $password = hash('sha256', $username);
                    // Verification Photo
                    if (isset($_FILES['img']))
                    {
                        $files = "p_".date("djY_hisa")."-".$username.".jpg";
                    } else {
                        if ($getData['sexe'] == 'M')
                        {
                            $files = "user-profile.png";
                        } else {
                            $files = "user-profile-woman.png";
                        }
                    }
                    // Insertion des donnees
                    $insert = $bdd->prepare("INSERT INTO employe(nomEmploye,prenomEmploye,sexeEmploye,adresseEmploye,numeroEmploye,dateDEmbauche,departEmploye,username,password,photoEmploye) VALUES 
                    (:nomEmploye,:prenomEmploye,:sexeEmploye,:adresseEmploye,:numeroEmploye,:dateDEmbauche,:departEmploye,:username,:password,:photoEmploye)");
                    $status = $insert->execute(array(
                        'nomEmploye'=>$getData['nom'],
                        'prenomEmploye'=>$getData['prenom'],
                        'sexeEmploye'=>$getData['sexe'],
                        'adresseEmploye'=>$getData['adresse'],
                        'numeroEmploye'=>$getData['numero'],
                        'photoEmploye'=>$files,
                        'dateDEmbauche'=>$getData['embauche'],
                        'departEmploye'=>((int)$getData['departement']),
                        'username'=>$username,
                        'password'=>$password
                    ));
                    // Upload photo si existe
                    if ($status)
                    {
                        if (isset($_FILES['img']))
                        {
                            $target_dir = "../../Photos/";
                            $target_file = $target_dir . $files;
                            move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
                        }
                        echo "done";
                    }
                } else {
                    echo "existe";
                }
            }
        }
    }
?>