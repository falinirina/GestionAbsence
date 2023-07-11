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
            <div class="title">
                <h4>Réstauration du mot de passe</h4>
            </div>
            <p style="text-align: center; margin-top: 55px;"><b><?=$employe['nomEmploye']." ".$employe['prenomEmploye'];?></b></p>
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
                        $.post("Traitements/resetKeyOp.php",{employe:"<?=$id?>", password: password, user: "<?= $_SESSION['administrateur'] ?>"},function(data){
                            $('#delete').html("")
                            $('#delete').css('display','none')
                            if (data == 'done') {
                                notification("Mot de passe réstauré avec succès")
                            } else {
                                notification("Erreur de réstauration du mot de passe de l'employé")
                            }
                            afficheData()
                            // console.log(data)
                        })
                    }
                    // console.log(password)
                })
            </script>
        </div>
        <?php
    }

?>