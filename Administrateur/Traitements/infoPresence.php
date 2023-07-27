<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['id']) && isset($_POST['date']))
    {
        require_once "./getDate.php";
        $dateC = date_create($_POST['date']);
        $fullDateText = dateTraitement::fullDate($dateC);
        $id = htmlspecialchars($_POST['id']);
        $date = htmlspecialchars(($_POST['date']));
        require_once "./config.php";

        $data = $bdd->query("SELECT matin,heureEntree,heureSortie,absent,remarque FROM  presence WHERE employePresence='$id' AND jourPresence='$date'");
        $row = $data->rowCount();
        ?>
        <h3 style="
        text-align: center;
        margin-top: 15px;
        "><?= $fullDateText ?></h3>
        <div class="resresSult">
        <?php
        if ($row > 0)
        {
            ?>
            <table class="ui table">
            <?php
            $data = $data->fetchAll();
            // var_dump($data);
            foreach ($data as $datum)
            {
                ?>
                <tr>
                    <td>
                        <h3><?php if ($datum['matin'] == "oui") { echo "Matin"; }
                        else { echo "Après-Midi"; }
                        ?></h3>
                    </td>
                    <td>
                        <?php
                        if ($datum['absent'] == "oui")
                        {
                            ?>
                            <div>Absent: <b><?= $datum['remarque']; ?></b></div>
                            <?php
                        } else {
                            ?>
                            <div>Entrée: <b><?= $datum['heureEntree'] ?></b> Sortie: <b><?= $datum['heureSortie'] ?></b> <?php
                                if ($datum['remarque'] != "")
                                {
                                    echo "Remarque: <b style='color:red'>".$datum['remarque']."</b>";
                                }
                            ?></div>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </table>
            <?php
        } else {
            ?>
            <div style="display: flex;    width: 100%;
            align-items: center;
            justify-content: center;
            font-size: 20px;">
                Pas de donnée
            </div>
            <?php
        }
        ?>
        </div>
        <?php
    }
?>