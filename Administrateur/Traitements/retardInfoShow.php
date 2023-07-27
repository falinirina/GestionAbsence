<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['id']))
    {
        $id = htmlspecialchars($_POST['id']);
        // echo $id;
        require_once "./config.php";
        $employe = $bdd->query("SELECT * FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE idEmploye=$id");
        $employeRow = $employe->rowCount();
        if ($employeRow == 1)
        {
            $employe = $employe->fetch();
            // var_dump($employe);
            ?>
            <div class="infoEmpIDK">
                <div class="topInfoEmp">
                    <div class="imgEmpInfo">
                        <img src="../Photos/<?= $employe['photoEmploye']; ?>" alt="Image">
                    </div>
                    <div class="infoEmpConf">
                        <div>
                            <div>Nom: <b><?= $employe['nomEmploye']; ?></b></div>
                            <div>Prenom: <b><?= $employe['prenomEmploye']; ?></b></div>
                            <div>Numero: <b><?= $employe['numeroEmploye']; ?></b></div>
                            <div>Departement: <b><?= $employe['nomDepartement']; ?></b></div>
                        </div>
                        <div>
                            <!-- <div>Utilisateur: <b><?= $employe['username']; ?></b></div> -->
                            <button class="ui button" onclick="viewDetails()">Plus de details</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="bottomRetard">
                    <?php
                     $verification = $bdd->query("SELECT * FROM presence WHERE employePresence=$id");
                     $verification = $verification->rowCount();
                     if ($verification == 0)
                     {
                        ?>
                        <div class="noData">Pas de donnée</div>
                        <?php
                     } else {
                        $dateMin = $bdd->query("SELECT MIN(jourPresence) FROM `presence` WHERE employePresence=$id");
                        $dateMin = $dateMin->fetch();
                        $dateMin = $dateMin[0];

                        $dateMax = $bdd->query("SELECT MAX(jourPresence) FROM `presence` WHERE employePresence=$id");
                        $dateMax = $dateMax->fetch();
                        $dateMax = $dateMax[0];

                        ?>
                        <div class="dateFilter">
                            <div class="ui form">
                                <label for="dateDebut" class="ui label">Debut</label>
                                <input type="date" name="dateDebut" id="dateDebut" min="<?=$dateMin;?>" value="<?=$dateMin;?>" max="<?=$dateMax;?>">
                            </div>
                            <div class="ui form">
                                <label for="dateFin" class="ui label">Fin</label>
                                <input type="date" name="dateFin" id="dateFin" min="<?=$dateMin;?>" value="<?=$dateMax;?>" max="<?=$dateMax;?>">
                            </div>
                            <div><button id="filtreBtn" class="ui button">Filtrer</button></div>
                        </div>
                        <div id="resultRetard"></div>
                        <?php

                     }
                    ?>
                </div>
                
            </div>
            <div id="viewDetails">
                <div class="bg-color">
                    <div class="topInfoEmp">
                        <div class="imgEmpInfo">
                            <img src="../Photos/<?= $employe['photoEmploye']; ?>" alt="Image">
                        </div>
                        <div class="infoEmpConf">
                            <div>
                                <div>Nom: <b><?= $employe['nomEmploye']; ?></b></div>
                                <div>Prenom: <b><?= $employe['prenomEmploye']; ?></b></div>
                                <div>Numero: <b><?= $employe['numeroEmploye']; ?></b></div>
                                <div>Departement: <b><?= $employe['nomDepartement']; ?></b></div>
                            </div>
                            <div>
                                <div>Identifiant: <b><?= $employe['idEmploye']; ?></b></div>
                                <div>Utilisateur: <b><?= $employe['username']; ?></b></div>
                                <div>Sexe: <b><?php 
                                    if ($employe['sexeEmploye'] == 'M') { echo "Masculin"; } 
                                    else { echo "Feminin"; }
                                ?></b></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="centerInfoEmp">
                        <div class="filtreDate">
                            <div class="ui form">
                                <label for="filtreDate" class="ui label">Date</label>
                                <input type="date" id="filtreDate" min="<?=$dateMin;?>" value="<?=$dateMin;?>" max="<?=$dateMax;?>">
                            </div>
                            <div>
                                <button class="ui blue button" onclick="searchLaunch()">Chercher</button>
                            </div>
                        </div>
                        <div id="resultSearch"></div>
                    </div>
                    <div class="bottomInfoEmp" style="
                        text-align: right;
                    ">
                        <button class="ui button red" onclick="closeThis()">Fermer</button>
                    </div>
                </div>
            </div>
            <?php
                if ($verification > 0)
                {
            ?>  
            <script>
                $("#dateDebut").change(function(){
                    $("#dateFin").attr('min', this.value)
                    // console.log(this.value)
                })
                $("#dateFin").change(function(){
                    $("#dateDebut").attr('max', this.value)
                    // console.log(this.value)
                })
                $.post("Traitements/infoRetard.php", {id: '<?= $id ?>'}, function (data) {
                    $("#resultRetard").html(data)
                })
                $("#filtreBtn").click(function(){
                    const dateDebut = $("#dateDebut").val()
                    const dateFin = $("#dateFin").val()
                    // console.log(dateDebut, dateFin)
                    $.post("Traitements/infoRetard.php", {id: '<?= $id ?>', debut: dateDebut, fin: dateFin }, function (data) {
                        $("#resultRetard").html(data)
                    })
                })
                function viewDetails()
                {
                    $("#viewDetails").css("display", "flex")
                }
                function closeThis()
                {
                    $("#viewDetails").css("display", "none")
                }
                function searchLaunch()
                {
                    date = $("#filtreDate").val()
                    $.post("Traitements/infoPresence.php",{
                        date: date,
                        id: '<?= $id; ?>'
                    }, function (data) {
                        $("#resultSearch").html(data)
                    })
                }
            </script>
            <?php
                }
            ?>
            
            <?php
        }
    }

?>