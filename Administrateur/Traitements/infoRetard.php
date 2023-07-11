<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['id']))
    {
        $id = htmlspecialchars($_POST['id']);
        require_once "./config.php";
        require_once "./getDate.php";
        if (isset($_POST['debut']) && isset($_POST['fin']))
        {
            $debut = htmlspecialchars($_POST['debut']);
            $fin = htmlspecialchars($_POST['fin']);
            $retard = $bdd->query("SELECT SUM(retardMinute) FROM `presence` WHERE employePresence=$id AND (jourPresence BETWEEN '$debut' AND '$fin')");
            $retard = $retard->fetch();
            $retard = $retard[0];
            $avance = $bdd->query("SELECT SUM(avanceMinute) FROM `presence` WHERE employePresence=$id AND (jourPresence BETWEEN '$debut' AND '$fin')");
            $avance = $avance->fetch();
            $avance = $avance[0];
        } else {
            $retard = $bdd->query("SELECT SUM(retardMinute) FROM `presence` WHERE employePresence=$id");
            $retard = $retard->fetch();
            $retard = $retard[0];
            $avance = $bdd->query("SELECT SUM(avanceMinute) FROM `presence` WHERE employePresence=$id");
            $avance = $avance->fetch();
            $avance = $avance[0];

            $debut = $bdd->query("SELECT MIN(jourPresence) FROM `presence` WHERE employePresence=$id");
            $debut = $debut->fetch();
            $debut = $debut[0];

            $fin = $bdd->query("SELECT MAX(jourPresence) FROM `presence` WHERE employePresence=$id");
            $fin = $fin->fetch();
            $fin = $fin[0];
        }
        ?>
        <hr>
        <div class="dateMessage">
            <h4>
                <?php
                    if ($debut == $fin)
                    {
                        ?>
                            Résultat du <?= dateTraitement::fullDate(date_create($debut)); ?>
                        <?php
                    } else {
                        ?>
                            Résultat du <?= dateTraitement::fullDate(date_create($debut)); ?> au <?= dateTraitement::fullDate(date_create($fin)); ?>
                        <?php
                    }

                ?>
               
            </h4>
        </div>
        <div>
            <div class="bg-color">
                <div class="top"><h4>Arrivé en retard</h4></div>
                <div class="middle"><?= $retard; ?> minutes</div>
                <div class="bottom">
                <?php
                    $retard = (int)$retard;
                    $heure = (int)($retard / 60);
                    $minute = $retard - ($heure * 60);
                    if ($minute == 0) {$minute = "";}
                    else {$minute = ((string)$minute)." minutes";}
                    $heure = (string)$heure." heures";
                    echo $heure." ".$minute;
                 ?>
                 </div>  
            </div>
            <div class="bg-color">
                <div class="top"><h4>Sortie en Avance</h4></div>
                <div class="middle"><?= $avance; ?> minutes</div>
                <div class="bottom">
                <?php
                    $avance = (int)$avance;
                    $heure = (int)($avance / 60);
                    $minute = $avance - ($heure * 60);
                    if ($minute == 0) {$minute = "";}
                    else {$minute = ((string)$minute)." minutes";}
                    $heure = (string)$heure." heures";
                    echo $heure." ".$minute;
                 ?>
                 </div>
            </div>
            <div class="bg-color">
                <?php $total = ($retard + $avance); ?>
                <div class="top"><h4>Total</h4></div>
                <div class="middle"><?= $total; ?> minutes</div>
                <div class="bottom">
                <?php
                    $total = (int)$total;
                    $heure = (int)($total / 60);
                    $minute = $total - ($heure * 60);
                    if ($minute == 0) {$minute = "";}
                    else {$minute = ((string)$minute)." minutes";}
                    $heure = (string)$heure." heures";
                    echo $heure." ".$minute;
                 ?>
                 </div>
            </div>
        </div>
        <?php
    }

?>