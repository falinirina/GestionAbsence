<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['id']) && isset($_POST['nom']))
    {
        ?>
            <div class="bg-color">
                <div class="title">
                    <h4>Modification Département</h4>
                </div>
                <div class="ui form">
                    <label for="mNomDepart" class="ui label">Nom departement</label>
                    <input type="text" name="mNomDepart" id="mNomDepart" value="<?= $_POST['nom'] ?>">
                </div>
                <div class="buttonDiv">
                    <button class="ui button green" disabled>Modifier</button>
                    <button class="ui button red">Annuler</button>
                </div>
            </div>
            <script>
                $("#mNomDepart").keyup(function(){
                    const nom = ($("#mNomDepart").val()).trim()
                    if (nom.length > 4 && nom != '<?= $_POST['nom'] ?>')
                    {
                        $("#modplusplus .button.ui.green").removeAttr('disabled')
                    } else {
                        $("#modplusplus .button.ui.green").attr('disabled', 'true')
                    }
                })
                $("#modplusplus .button.ui.green").click(function(){
                    const nom = ($("#mNomDepart").val()).trim()
                    if (nom.length < 4)
                    {
                        notification("Nom departement trop court")
                    } else {
                        $.post("Traitements/modDepartementOp.php", {
                            id: '<?= $_POST['id'] ?>',
                            nom: nom
                        }, function (data){
                            // console.log(data)
                            if (data == 'done')
                            {
                                $("#modplusplus").html('')
                                $("#modplusplus").css('display', 'none')
                                notification('Departement modifié avec succès')
                                afficheDepartement()
                            } else {
                                $("#modplusplus").html('')
                                $("#modplusplus").css('display', 'none')
                                notification('Erreur de modification')
                            }
                        })
                    }
                })
                $("#modplusplus .button.ui.red").click(function(){
                    $("#modplusplus").html('')
                    $("#modplusplus").css('display', 'none')
                })
            </script>
        <?php
    }

?>