<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['date']))
    {
        $date = htmlspecialchars($_POST['date']);
        require_once "./config.php";
        $employe = $bdd->query("SELECT idEmploye,nomEmploye,prenomEmploye FROM employe WHERE NOT typeCompte='admin'");

        $employeRow = $employe->rowCount();
        if ($employeRow == 0)
        {
            echo "No data";
        } else {
            $dateC = date_create($date);
            $dateJour = date_format($dateC, "N");

            require_once "./getDate.php";
            $fullDateText = dateTraitement::fullDate($dateC);
            ?>
            <div><?= $fullDateText; ?></div>
            <?php

            if ($dateJour != 7)
            {
                $dateN = date_create();
                $dateN = date_format($dateN, "Y-m-d");
    
                foreach ($employe as $mpiasa)
                {
                    $id = $mpiasa['idEmploye'];
                    $nom = $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye'];
                    if ($date == $dateN)
                    {
                        echo "Eto";
                    } else {
                        $data = $bdd->query("SELECT * FROM presence WHERE jourPresence='$date' AND employePresence=$id");
                        $dataRow = $data->rowCount();
                        // echo $dataRow;
                        if ($dataRow == 0)
                        {
                            if ($dateJour == 6)
                            {
                                ?>
                                <div>
                                    <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                    <button class="ui button green" onclick="samediAdd('<?= $id ?>', '<?= $nom?>')">Ajouter</button>
                                </div>
                                <?php
                            } else {
                                ?>
                            <div>
                                <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                <div><button class="ui button green" onclick="matinAdd('<?= $id ?>', '<?= $nom?>')">Matin</button><button class="ui button green" onclick="midiAdd('<?= $id ?>', '<?= $nom?>')">Midi</button></div>
                            </div>
                                <?php
                            }
                        } else if ($dataRow == 1)
                        {
                            $dataNew = $data->fetch();
                            if ($dateJour == 6)
                            {
                                if ($dataNew['heureSortie'] == null && $dataNew['absent'] == 'non')
                                {
                                    ?>
                                    <div>
                                        <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                        <div><button class="ui button green" onclick="matinSort('<?= $id ?>', '<?= $nom?>')">Sortie Matin</button></div>
                                    </div>
                                    <?php
                                }
                            } else {
                                if ($dataNew['matin'] == 'oui')
                                {
                                    if ($dataNew['heureSortie'] == null && $dataNew['absent'] == 'non')
                                    {
                                        ?>
                                        <div>
                                            <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                            <div><button class="ui button green" onclick="matinSort('<?= $id ?>', '<?= $nom?>')">Sortie Matin</button><button class="ui button green" onclick="midiAdd('<?= $id ?>', '<?= $nom?>')">Midi</button></div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div>
                                            <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                            <div><button class="ui button green" onclick="midiAdd('<?= $id ?>', '<?= $nom?>')">Midi</button></div>
                                        </div>
                                        <?php
                                    }
                               } else {
                                    if ($dataNew['heureSortie'] == null && $dataNew['absent'] == 'non')
                                    {
                                        ?>
                                        <div>
                                            <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                            <div><button class="ui button green" onclick="matinAdd('<?= $id ?>', '<?= $nom?>')">Matin</button><button class="ui button green" onclick="midiSort('<?= $id ?>', '<?= $nom?>')">Sortie Midi</button></div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div>
                                            <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                            <div><button class="ui button green" onclick="matinAdd('<?= $id ?>', '<?= $nom?>')">Matin</button></div>
                                        </div>
                                        <?php
                                    }
                               }
                                ?>
                                
                                <?php
                            }
                        } else if ($dataRow == 2) {
                            $dataNew = $data->fetchAll();
                            foreach ($dataNew as $donnee) {
                                if ($donnee['matin'] == "non") {
                                    $midi = $donnee;
                                } else {
                                    $matin = $donnee;
                                }
                            } 
                            if ($matin['heureSortie'] == null  && $matin['absent'] == 'non' && $midi['heureSortie'] == null  && $midi['absent'] == 'non')
                            {
                                ?>
                                <div>
                                    <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                    <div><button class="ui button green" onclick="matinSort('<?= $id ?>', '<?= $nom?>')">Sortie Matin</button><button class="ui button green" onclick="midiSort('<?= $id ?>', '<?= $nom?>')">Sortie Midi</button></div>
                                </div>
                                <?php
                            } else {
                                if ($matin['heureSortie'] == null && $matin['absent'] == 'non')
                                {
                                    ?>
                                    <div>
                                        <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                        <div><button class="ui button green" onclick="matinSort('<?= $id ?>', '<?= $nom?>')">Sortie Matin</button></div>
                                    </div>
                                    <?php
                                } else if ($midi['heureSortie'] == null && $midi['absent'] == 'non')
                                {
                                    ?>
                                <div>
                                    <div><?= $mpiasa['nomEmploye']." ".$mpiasa['prenomEmploye']; ?></div>
                                    <div><button class="ui button green" onclick="midiSort('<?= $id ?>', '<?= $nom?>')">Sortie Midi</button></div>
                                </div>
                                <?php
                                }
                            }
                            ?>
                            <?php
                        }
                    }
                }
            } else {
                echo "Dimanche";
            }
        }
    }
    
    ?>
    <script>
        function samediAdd(getId, nom)
        {
            $.post("Traitements/getFormPres.php", {
                date: '<?= $date ?>',
                matin: 'oui',
                id: getId,
                nom: nom,
            }, function (data){
                $("#addPresence").html(data)
                $("#addPresence").css('display', 'flex')
            })
        }
        function matinAdd(getId, nom)
        {
            $.post("Traitements/getFormPres.php", {
                date: '<?= $date ?>',
                matin: 'oui',
                id: getId,
                nom: nom,
            }, function (data){
                $("#addPresence").html(data)
                $("#addPresence").css('display', 'flex')
            })
        }
        function midiAdd(getId,nom)
        {
            $.post("Traitements/getFormPres.php", {
                date: '<?= $date ?>',
                matin: 'non',
                id: getId,
                nom: nom,
            }, function (data){
                $("#addPresence").html(data)
                $("#addPresence").css('display', 'flex')
            })
        }
        function matinSort(getId, nom)
        {
            $.post("Traitements/getFormSort.php", {
                date: '<?= $date ?>',
                matin: 'oui',
                id: getId,
                nom: nom,
            }, function (data){
                $("#addPresence").html(data)
                $("#addPresence").css('display', 'flex')
            })
        }
        function midiSort(getId, nom)
        {
            $.post("Traitements/getFormSort.php", {
                date: '<?= $date ?>',
                matin: 'non',
                id: getId,
                nom: nom,
            }, function (data){
                $("#addPresence").html(data)
                $("#addPresence").css('display', 'flex')
            })
        }
    </script>