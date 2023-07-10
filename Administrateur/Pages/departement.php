<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        ?>
        <div id="form-departement" class="form01 ui form bg-color">
            <h3 class="title">Departements</h3>
            <div class="addDepForm">
                <input type="text" name="departement" id="departementText">
                <button id="addDepBtn" class="ui blue button">Ajouter</button>
            </div>
            <hr style="width: 100%;">
            <div id="listeDep"></div>
            <div id="buttonDep">
                <button class="ui red button">Fermer</button>
            </div>
        </div>
        <script>
            $("#buttonDep>.ui.red.button").click(function(){
                $("#add-font").css('display','none')
                $("#add-font").html('')
            })
            $("#addDepBtn").click(function(){
                const nomDepartement = ($("#departementText").val()).trim()
                if (nomDepartement.length > 4)
                {
                    $.post("Traitements/addDepartement.php", {nomDepartement: nomDepartement}, function(data){
                        if (data == 'done') {
                            afficheDepartement();
                            $("#departementText").val("")
                            notification("Département ajouter avec succès")
                        } else {
                            notification("Ce département éxiste déjà")
                        }
                        $("#listeDep").html(resultat)
                    })
                } else {
                    notification("Nom département trop court")
                }
            })
            function afficheDepartement()
            {
                $.post("Traitements/getDepartement.php", {}, function(data){
                    if (data == 'vide') {
                        resultat = "<b>Pas de departement</b>"
                    } else {
                        resultat = data
                    }
                    $("#listeDep").html(resultat)
                })
            }
            afficheDepartement()
        </script>
        <?php
    }
?>