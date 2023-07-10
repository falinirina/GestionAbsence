<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe'])
        && isset($_POST['id']) && isset($_POST['adresse']) && isset($_POST['numero']) 
        && isset($_POST['embauche']) && isset($_POST['departement']) )
        {
            require_once "config.php";
            // var_dump($_POST);
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
    
            $update = $bdd->prepare("UPDATE employe SET nomEmploye=:nom, prenomEmploye=:prenom,sexeEmploye=:sexe, adresseEmploye=:adresse, numeroEmploye=:numero, dateDEmbauche=:embauche, departEmploye=:departement WHERE idEmploye=".$getData['id']);
            $res = $update->execute(array(
                'nom'=>$getData['nom'],
                'prenom'=>$getData['prenom'],
                'sexe'=> $getData['sexe'],
                'adresse'=>$getData['adresse'],
                'numero'=>$getData['numero'],
                'embauche'=>$getData['embauche'],
                'departement'=>$getData['departement']
            ));
            if ($res) {echo "done";}
        }
    }


?>