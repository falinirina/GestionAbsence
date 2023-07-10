<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['search'])) {
        require_once "./config.php";
        $search = htmlspecialchars($_POST['search']);
        $employe = $bdd->query("SELECT idEmploye ,nomEmploye, prenomEmploye, nomDepartement FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE (nomEmploye LIKE '$search%' OR prenomEmploye LIKE '$search%') AND NOT typeCompte='admin' LIMIT 5");
        $row = $employe->rowCount();
        $employe = $employe->fetchAll();
        $dateNow = date_create();
        $dateNow = date_format($dateNow, "Y-m-d");
        if ($row == 0)
        {
            ?>
            <tr><td>Pas de résultat</td></tr>
            <?php
        } else {
            foreach ($employe as $data)
            {
                ?>
                <tr>
                <td onclick="viewEmploye('<?= $data['idEmploye']; ?>')"><?= $data['nomEmploye']."<br>".$data['prenomEmploye']; ?></td>
                </tr>
                <?php
            }
        }
    }
?>