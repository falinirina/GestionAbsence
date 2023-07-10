<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['matin']) && isset($_POST['id']) && isset($_POST['date']) && isset($_POST['sortie']))
    {
        require "./config.php";
        $id = htmlspecialchars($_POST['id']);
        $date = htmlspecialchars($_POST['date']);
        $matin = htmlspecialchars($_POST['matin']);
        $sortie = $_POST['sortie'];
        $check = $bdd->query("SELECT * FROM presence WHERE jourPresence='$date' AND employePresence=$id AND matin='$matin'");
        $row = $check->rowCount();
        if ($row == 1)
        {
            $data = $check->fetch();
            if ($data['heureSortie'] == null)
            {
                $sortieInt[0] = (int)$sortie[0];
                $sortieInt[1] = (int)$sortie[1];
                for ($i=0;$i<2;$i++){
                    if ($sortie[$i] < 10)
                    {
                        $sortie[$i] = "0".$sortie[$i];
                    }
                }
                $sortie = $sortie[0].":".$sortie[1];
                $heureSupE = (int)$data['travailMinute'];
                $retard = (int)$data['retardMinute'];
    
                if ($_POST['matin'] == "oui")
                {
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
                    $bdd->query("UPDATE presence SET heureSortie='$sortie', avanceMinute=$avance, travailMinute=$traivailMinute WHERE jourPresence='$date' AND employePresence=$id AND matin='$matin'");
                    echo "done";
                } else {
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
                    $bdd->query("UPDATE presence SET heureSortie='$sortie', avanceMinute=$avance, travailMinute=$traivailMinute WHERE jourPresence='$date' AND employePresence=$id AND matin='$matin'");
                    echo "done";
                }
            }
        }
    }

?>