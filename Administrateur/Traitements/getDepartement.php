<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        require_once "config.php";
        $result = $bdd->query("SELECT * FROM departement");
        $row = $result->rowCount();
        if ($row != 0)
        {
            $data = $result->fetchAll();
            if (isset($_POST['typeResultat']))
            {
                $type = htmlspecialchars($_POST['typeResultat']);
                if ($type == 'select'){
                    foreach ($data as $departement)
                    {
                        ?>
                        <option value="depart<?= $departement['idDepartement']; ?>"><?= $departement['nomDepartement']; ?></option>
                        <?php
                    }
                }
            } else {
                foreach ($data as $departement)
                {
                    ?>
                    <div class='contentDepartement'>
                        <div><b><?= $departement['nomDepartement'] ?></b></div>
                        <div>
                            <button class="ui button green" onclick="modifierDepartement('<?= $departement['idDepartement']; ?>', '<?= $departement['nomDepartement'] ?>')"><i class="ui icon edit"></i></button>
                            <button class="ui button red" onclick="supprimerDepartement('<?= $departement['idDepartement']; ?>')"><i class="ui icon close"></i></button>
                        </div>
                    </div>
                    <script>
                        function modifierDepartement(getId, getNom)
                        {
                            const idDep = getId
                            const nom = getNom
                            $.post("Traitements/modDepartementForm.php",{
                                id: idDep,
                                nom: nom
                            }, function (data){
                                $("#modplusplus").html(data)
                                $("#modplusplus").css('display', 'flex')
                            })
                            
                        }
                        function supprimerDepartement(getId)
                        {
                            const idDep = getId
                            $.post("Traitements/delDepartement.php", {id: idDep}, function(data){
                                if (data == 'done')
                                {
                                    afficheDepartement()
                                    notification("Département supprimé avec succès")
                                } else {
                                    notification("Il y a des employés dans ce département")
                                }
                            })
                        }
                    </script>
                    <?php
                }
            }
        } else {
            echo "vide";
        }
    }

?>