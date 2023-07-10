<?php
    session_start();
    if (isset($_POST['employe']))
    {
        require_once "./config.php";
        $id = htmlspecialchars($_POST['employe']);
        $employe = $bdd->query("SELECT * FROM employe WHERE idEmploye='$id'");
        $employe = $employe->fetch();
        // var_dump($employe);

        ?>
        <div class="bg-color">
            <div class="iIcon"><i class="ui icon info circle"></i></div>
            <p>Etes-vous sûr de vouloir supprimer l'employe</p>
            <p style="text-align: center;"><b><?=$employe['nomEmploye']." ".$employe['prenomEmploye'];?></b></p>
            <div class="ui form">
                <input type="password" name="password" id="passwordMod" placeholder="Entrer le mot de passe">
            </div>
            <div class="mButton">
                <button class="ui button red">Non</button>
                <button class="ui button blue">Oui</button>
            </div>
            <div id="test"></div>
            <script>
                $("#delete .ui.button.red").click(function(){
                    $('#delete').html("")
                    $('#delete').css('display','none')
                })
                $("#delete .ui.button.blue").click(function(){
                    var password = $("#passwordMod").val()
                    if (password != "")
                    {
                        $.post("Traitements/delEmployeOp.php",{employe:"<?=$id?>", password: password, user: "<?= $_SESSION['administrateur'] ?>"},function(data){
                            $('#delete').html("")
                            $('#delete').css('display','none')
                            if (data == 'done') {
                                notification("Employé supprimé avec succès")
                            } else {
                                notification("Erreur de suppression de l'employé")
                            }
                            afficheData()
                        })
                    }
                    console.log(password)
                })
            </script>
        </div>
        <?php
    }

?>