<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['matin']))
    {
        if (isset($_POST['id']) && isset($_POST['date']) && isset($_POST['entree']) && isset($_POST['sortie']))
        {
            require_once "./config.php";
            
            $id = htmlspecialchars($_POST['id']);
            $date = htmlspecialchars($_POST['date']);
            $matin = htmlspecialchars($_POST['matin']);
            $check = $bdd->query("SELECT * FROM presence WHERE jourPresence='$date' AND employePresence=$id AND matin='$matin'");
            $check = $check->rowCount();
            if ($check == 0)
            {
                $entree = $_POST['entree'];
                $sortie = $_POST['sortie'];
    
                $entreeInt[0] = (int)$entree[0];
                $entreeInt[1] = (int)$entree[1];
                for ($i=0;$i<2;$i++){
                    if ($entree[$i] < 10)
                    {
                        $entree[$i] = "0".$entree[$i];
                    }
                }
                $entree = $entree[0].":".$entree[1];
    
                $sortieInt[0] = (int)$sortie[0];
                $sortieInt[1] = (int)$sortie[1];
                for ($i=0;$i<2;$i++){
                    if ($sortie[$i] < 10)
                    {
                        $sortie[$i] = "0".$sortie[$i];
                    }
                }
                $sortie = $sortie[0].":".$sortie[1];
                if ($_POST['matin'] == "oui")
                {
                    // Entree
                    if ($entreeInt[0] >= 8) {
                        $retard = ($entreeInt[0] - 8) + $entreeInt[1];
                        $heureSupE = 0;
                    }
                    else {
                        $retard = 0;
                        $heureSupE = 60 - $entreeInt[1];
                    }
                    // Sortie
                    if ($sortieInt[0] < 12) {
                        $avance = ((12 - $sortieInt[0]) * 60) - $sortieInt[1];
                        $heureSupS = 0;
                    }
                    else {
                        $avance = 0;
                        $heureSupS = (($sortieInt[0] - 12) * 60) + $sortieInt[1];
                    }
                    $traivailMinute = 240 - $avance - $retard + $heureSupE + $heureSupS;
                    $traivailMinute = (int)$traivailMinute;
    
    
                    $insert = $bdd->prepare("INSERT INTO presence(jourPresence, employePresence, heureEntree, heureSortie, retardMinute,avanceMinute, matin, travailMinute)
                    VALUES (:jourPresence,:employePresence,:heureEntree,:heureSortie,:retardMinute,:avanceMinute,:matin,:travailMinute)");
                    $check = $insert->execute(array(
                        'jourPresence'=>$date,
                        'employePresence'=>$id,
                        'heureEntree'=>$entree,
                        'heureSortie'=>$sortie,
                        'retardMinute'=>$retard,
                        'avanceMinute'=>$avance,
                        'matin'=>$matin,
                        'travailMinute'=>$traivailMinute 
                    ));
                    if ($check)
                    {
                        echo "done";
                    }
                } else if ($_POST['matin'] == 'non')
                {
                    // Entree
                    if ($entreeInt[0] >= 14) {
                        $retard = ($entreeInt[0] - 14) + $entreeInt[1];
                        $heureSupE = 0;
                    }
                    else {
                        $retard = 0;
                        $heureSupE = 60 - $entreeInt[1];
                    }
                    // Sortie
                    if ($sortieInt[0] < 18) {
                        $avance = ((18 - $sortieInt[0]) * 60) - $sortieInt[1];
                        $heureSupS = 0;
                    }
                    else {
                        $avance = 0;
                        $heureSupS = (($sortieInt[0] - 18) * 60) + $sortieInt[1];
                    }
                    $traivailMinute = 240 - $avance - $retard + $heureSupE + $heureSupS;
                    $traivailMinute = (int)$traivailMinute;
    
    
                    $insert = $bdd->prepare("INSERT INTO presence(jourPresence, employePresence, heureEntree, heureSortie, retardMinute,avanceMinute, matin, travailMinute)
                    VALUES (:jourPresence,:employePresence,:heureEntree,:heureSortie,:retardMinute,:avanceMinute,:matin,:travailMinute)");
                    $check = $insert->execute(array(
                        'jourPresence'=>$date,
                        'employePresence'=>$id,
                        'heureEntree'=>$entree,
                        'heureSortie'=>$sortie,
                        'retardMinute'=>$retard,
                        'avanceMinute'=>$avance,
                        'matin'=>$matin,
                        'travailMinute'=>$traivailMinute 
                    ));
                    if ($check)
                    {
                        echo "done";
                    }
                }
            }
            
        } else {
            if (isset($_POST['id']) && isset($_POST['absent']) && isset($_POST['date']))
            {
                require_once "./config.php";

                $id = htmlspecialchars($_POST['id']);
                $absent = htmlspecialchars($_POST['absent']);
                $date = htmlspecialchars($_POST['date']);
                $matin = htmlspecialchars($_POST['matin']);

                $check = $bdd->query("SELECT * FROM presence WHERE jourPresence='$date' AND employePresence=$id AND matin='$matin'");
                $check = $check->rowCount();
                if ($check == 0)
                {
                    $insert = $bdd->prepare("INSERT INTO presence(jourPresence, employePresence, matin, absent)
                    VALUES (:jourPresence,:employePresence,:matin,:absent)");
                    $check = $insert->execute(array(
                        'jourPresence'=>$date,
                        'employePresence'=>$id,
                        'matin'=>$matin,
                        'absent'=>$absent
                    ));
                    if ($check)
                    {
                        echo "done";
                    }
                }
            }
        }
    }


?>