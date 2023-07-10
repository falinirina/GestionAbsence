<?php
    session_start();
    if (isset($_SESSION['utilisateur']) && isset($_SESSION['infoUtilisateur']) && isset($_POST['action']))
    {
        require_once "../../Administrateur/Traitements/config.php";

        $action = htmlspecialchars($_POST['action']);
        
        $check = $bdd->query("SELECT username FROM employe WHERE idEmploye='".$_SESSION['infoUtilisateur']['id']."'");
        $check = $check->rowCount();
        
        if ($check == 1) {
            $id = (int)$_SESSION['infoUtilisateur']['id'];
            $date = date_create();
            
            $hour = (int)date_format($date,"H");
            $minute = (int)date_format($date,"i");
            $jour = date_format($date,"Y-m-d");
            
            $checkMatin = $bdd->query("SELECT * FROM presence WHERE jourPresence='$jour' AND employePresence=$id");
            
            $checkMatinRow = $checkMatin->rowCount();
            $day = date_format($date,'N');
            if ($day != 7)
            {
                if ($checkMatinRow == 0 )
                {
                    if ($action == 'entree')
                    {
                        if ($hour <= 12)
                        {
                            if ($hour >= 7 && $hour <= 10)
                            {
                                // Matin
                                $heureEntree = date_format($date,"H:i");
                                $matin = "oui";
                                if ($hour >= 8) {
                                    $retard = ($hour - 8) + $minute;
                                    $heureSup = 0;
                                }
                                else {
                                    $retard = 0;
                                    $heureSup = 60 - $minute;
                                }
                                $insert = $bdd->prepare("INSERT INTO presence(jourPresence, employePresence, heureEntree, retardMinute, matin, travailMinute)
                                VALUES (:jourPresence,:employePresence,:heureEntree,:retardMinute,:matin,:travailMinute)");
                                $check = $insert->execute(array(
                                    'jourPresence'=>$jour,
                                    'employePresence'=>$id,
                                    'heureEntree'=>$heureEntree,
                                    'retardMinute'=>$retard,
                                    'matin'=>$matin,
                                    'travailMinute'=>$heureSup
                                    
                                ));
                                if ($check)
                                {
                                    echo "done";
                                }
                            }
                        } else if ($hour >= 13 && $hour <= 15)
                        {
                            // Apres Midi si Absent Matin
                            if ($day != 6)
                            {
                                $heureEntree = date_format($date,"H:i");
                                $matin = "non";
                                if ($hour >= 14) {
                                    $retard = ($hour - 14) + $minute;
                                    $heureSup = 0;
                                }
                                else {
                                    $retard = 0;
                                    $heureSup = 60 - $minute;
                                }
                                $insert = $bdd->prepare("INSERT INTO presence(jourPresence, employePresence, heureEntree, retardMinute, matin, travailMinute)
                                VALUES (:jourPresence,:employePresence,:heureEntree,:retardMinute,:matin,:travailMinute)");
                                $check = $insert->execute(array(
                                    'jourPresence'=>$jour,
                                    'employePresence'=>$id,
                                    'heureEntree'=>$heureEntree,
                                    'retardMinute'=>$retard,
                                    'matin'=>$matin,
                                    'travailMinute'=>$heureSup
    
                                ));
                                // var_dump($insert);
                                if ($check)
                                {
                                    echo "done";
                                }
                            }
                        }
                    }
                } else if ($checkMatinRow == 1)
                {
                    if ($action == 'sortie')
                    {
                        $checkMatin = $checkMatin->fetch();
                        if ($hour >= 8)
                        {
                            $heureSortie = date_format($date,"H:i");
                            $heureEntree = $checkMatin['heureEntree'];
                            // Calcule heure de travail
    
                            if ($checkMatin['matin'] == "oui")
                            {
                                // Sortie du matin
                                if ($hour > $checkMatin['heureEntree'])
                                {
                                    if ($hour < 12) {
                                        $avance = ((12 - $hour) * 60) - $minute;
                                        $heureSup = 0;
                                    }
                                    else {
                                        $avance = 0;
                                        $heureSup = (($hour - 12) * 60) + $minute;
                                    }
                                    $heureSup = ((int)$checkMatin['travailMinute']) + $heureSup;
                                    $traivailMinute = 240 - ((int)$checkMatin['retardMinute']) - $avance + $heureSup;
                                    
                                    $update = $bdd->prepare("UPDATE presence SET heureSortie=:sortie, avanceMinute=:avance,travailMinute=:travail WHERE idPresence=".$checkMatin['idPresence']);
                                    $res = $update->execute(array(
                                        'sortie'=>$heureSortie,
                                        'avance'=>$avance,
                                        'travail'=> $traivailMinute
                                    ));
                                    if ($res)
                                    {
                                        echo "done";
                                    }
                                }
                            } else {
                                
                                // Sortie de l'apres Midi si Matin Absent
                                if ($hour > $checkMatin['heureEntree'])
                                {
                                    if ($hour < 18) {
                                        $avance = ((18 - $hour) * 60) - $minute;
                                        $heureSup = 0;
                                    }
                                    else {
                                        $avance = 0;
                                        $heureSup = (($hour - 18) * 60) + $minute;
                                    }
                                    $heureSup = ((int)$checkMatin['travailMinute']) + $heureSup;
                                    $traivailMinute = 240 - ((int)$checkMatin['retardMinute']) - $avance + $heureSup;
                                    
                                    $update = $bdd->prepare("UPDATE presence SET heureSortie=:sortie, avanceMinute=:avance,travailMinute=:travail WHERE idPresence=".$checkMatin['idPresence']);
                                    $res = $update->execute(array(
                                        'sortie'=>$heureSortie,
                                        'avance'=>$avance,
                                        'travail'=> $traivailMinute
                                    ));
                                    if ($res)
                                    {
                                        echo "done";
                                    }
                                }
                            }
                        }
                    } else if ($action == 'entree')
                    {
                        // Entree Apres Midi si present matin
                        if ($hour >= 13 && $hour <= 15)
                        {
                            if ($day != 6)
                            {
                                $heureEntree = date_format($date,"H:i");
                                $matin = "non";
                                if ($hour >= 14) {
                                    $retard = ($hour - 14) + $minute;
                                    $heureSup = 0;
                                }
                                else {
                                    $retard = 0;
                                    $heureSup = 60 - $minute;
                                }
                                $insert = $bdd->prepare("INSERT INTO presence(jourPresence, employePresence, heureEntree, retardMinute, matin, travailMinute)
                                VALUES (:jourPresence,:employePresence,:heureEntree,:retardMinute,:matin,:travailMinute)");
                                $check = $insert->execute(array(
                                    'jourPresence'=>$jour,
                                    'employePresence'=>$id,
                                    'heureEntree'=>$heureEntree,
                                    'retardMinute'=>$retard,
                                    'matin'=>$matin,
                                    'travailMinute'=>$heureSup
    
                                ));
                                // var_dump($insert);
                                if ($check)
                                {
                                    echo "done";
                                }
                            }
                        }
                    }
                } else if ($checkMatinRow == 2)
                {
                    if ($action == 'sortie')
                    {
                        $checkMatinT = $checkMatin->fetchAll();
                        foreach ($checkMatinT as $checkMat)
                        {
                            if ($checkMat['matin'] == 'non')
                            {
                                $result = $checkMat;
                            }
                        }
                        $checkMatin = $result;

                        $heureSortie = date_format($date,"H:i");
                        $heureEntree = $checkMatin['heureEntree'];
                        // Calcule heure de travail

                        if ($checkMatin['matin'] == "non")
                        {
                            if ($hour > $checkMatin['heureEntree'])
                            {
                                if ($hour < 18) {
                                    $avance = ((18 - $hour) * 60) - $minute;
                                    $heureSup = 0;
                                }
                                else {
                                    $avance = 0;
                                    $heureSup = (($hour - 18) * 60) + $minute;
                                }
                                $heureSup = ((int)$checkMatin['travailMinute']) + $heureSup;
                                $traivailMinute = 240 - ((int)$checkMatin['retardMinute']) - $avance + $heureSup;
                                
                                $update = $bdd->prepare("UPDATE presence SET heureSortie=:sortie, avanceMinute=:avance,travailMinute=:travail WHERE idPresence=".$checkMatin['idPresence']);
                                $res = $update->execute(array(
                                    'sortie'=>$heureSortie,
                                    'avance'=>$avance,
                                    'travail'=> $traivailMinute
                                ));
                                if ($res)
                                {
                                    echo "done";
                                }
                            }
                        }
                    }
                    // Sortie Apres Midi si matin present
                }
            }
        }
    }

?>