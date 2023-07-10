<?php
    session_start();
    if (isset($_SESSION['utilisateur']) && isset($_SESSION['infoUtilisateur']))
    {
        require_once "../../Administrateur/Traitements/config.php";
        $check = $bdd->query("SELECT username FROM employe WHERE idEmploye='".$_SESSION['infoUtilisateur']['id']."'");
        $check = $check->rowCount();

        if ($check == 1)
        {
            $id = $_SESSION['infoUtilisateur']['id'];
            require_once "getDate.php";
            $date = date_create();
            // $fullDateText = dateTraitement::fullDate($date);

            $hour = (int)date_format($date,"H");
            $minute = (int)date_format($date, "i");
            $jour = date_format($date,"Y-m-d");
            $checkMatin = $bdd->query("SELECT * FROM presence WHERE jourPresence='$jour' AND employePresence=$id");
            $checkMatinRow = $checkMatin->rowCount();
            $day = date_format($date,'N');
            
            if ($day != 7)
            {
                if ($checkMatinRow == 0)
                {
                    if ($hour <= 12)
                    {
                        if ($hour >= 7)
                        {
                            if ($hour < 10)
                            {
                                ?>
                                <button id="entree" class='ui button green'>Entree Matin</button>
                                <?php
                            } else {
                                ?>
                                <div class="message">
                                    Entrée trop en retard, veuillez contacter l'Administrateur
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                                <div class="message">
                                    Bonjour, La presence commence à partir de 7h
                                </div>
                                <script>
                                    setTimeout(checkPresence,5000);
                                </script>
                            <?php
                        }
                    } else {
                        if ($hour <= 18)
                        {
                            if ($day == 6){
                                ?>
                                    <div class="message">
                                        Bonne Samedi à tous
                                    </div>
                                <?php
                            } else {
                                ?>
                                    <button id="entree" class='ui button green'>Entree Apres Midi</button>
                                <?php
                            }
                        } else {
                            ?>
                                <div class="message">
                                    Bonjour, La presence commence à partir de 13h
                                </div>
                                <script>
                                    setTimeout(checkPresence,5000);
                                </script>
                            <?php
                        }
                    }
                } else
                {
                    if ($checkMatinRow == 1)
                    {
                        $checkMatin = $checkMatin->fetch();
                        if ($checkMatin['heureSortie'] == null)
                        {
                            if ($checkMatin['matin'] == 'oui')
                            {
                                if ($hour < 10)
                                {
                                    ?>
                                    <div class="message">La sortie commence à partir de 10h ou contacter votre Administrateur</div>
                                    <?php
                                } else {
                                ?>
                                    <button id="sortie" class='ui button red'>Sortie Matin</button>
                                <?php
                                }
                            } else {
                                if ($hour < 16)
                                {
                                    ?>
                                    <div class="message">La sortie commence à partir de 16h ou contacter votre Administrateur</div>
                                    <?php
                                } else {
                                    ?>
                                        <button id="sortie" class='ui button red'>Sortie Apres-Midi</button>
                                    <?php
                                }
                            }
                        } else {
                            if ($checkMatin['matin'] == "oui")
                            {
                                if ($hour >= 13)
                                {
                                    if ($day == 6){
                                        ?>
                                            <div class="message">
                                        Bonne Samedi à tous
                                    </div>
                                        <?php
                                    } else {
                                        ?>
                                            <button id="entree" class='ui button green'>Entree Apres Midi</button>
                                        <?php
                                    }
                                } else {
                                    if ($day == 6)
                                    {
                                        ?>
                                    <div class="message">
                                        Bonne Samedi à tous
                                    </div>
                                    <?php
                                    } else {
                                        if ($hour < 12)
                                        {
                                            ?>
                                            <div class="message">
                                                Bonne journée
                                            </div>
                                            <?php
                                        } else {
                                            if ($hour < 13 && $minute < 30)
                                            {
                                                ?>
                                                <div class="message">
                                                    Bonne journée
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="message">
                                                    La presence du midi commence à partir de 13h
                                                </div>
                                                <script>
                                                    setTimeout(checkPresence,5000);
                                                </script>
                                                <?php

                                            }
                                        }

                                    }
                                }
                            } else {
                                ?>
                                    <div class="message">
                                        Bonne Soirée
                                    </div>
                                <?php
                            }
                        }
                    } else if ($checkMatinRow == 2)
                    {
                        $checkMatin = $checkMatin->fetchAll();
                        foreach ($checkMatin as $checkMidi)
                        {
                            if ($checkMidi['matin'] == "oui") { }
                            else {
                                if ($checkMidi['heureSortie'] == null)
                                {
                                    if ($hour < 16)
                                    {
                                        ?>
                                        <div class="message">La sortie commence à partir de 16h ou contacter votre Administrateur</div>
                                        <?php
                                    } else {
                                        ?>
                                            <button id="sortie" class='ui button red'>Sortie Apres-Midi</button>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="message">
                                        Bonne Soirée
                                    </div>
                                    <?php
                                }
                            }
                        }
                    }
                }
            } else {
                ?>
                    <div class="message">
                        Bonne Dimanche à tous
                    </div>
                <?php
            }
        }
    }
?>
<script>
    $("#presenceCont #entree").click(function(){
        const action = "entree"
        // console.log(action)
        $.post("Traitements/pointagePresence.php", {
            action: action
        }, function (data){
            if (data == "done")
            {
                checkPresence();
            }
        })
    })
    $("#presenceCont #sortie").click(function(){
        $.post("Traitements/sortirForm.php", {}, function(data){
            $("#cmdp").html(data)
            $("#cmdp").css('display', 'flex')
        })
    })
</script>