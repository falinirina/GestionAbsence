<?php
    if (isset($_POST['employe']))
    {
        $idEmploye=htmlspecialchars($_POST['employe']);
        require_once "../Traitements/config.php";
        $employe=$bdd->query("SELECT * FROM employe WHERE idEmploye='$idEmploye'");
        $employe=$employe->fetch();
        $departement=$bdd->query("SELECT * FROM departement");
        $departement = $departement->fetchAll();
        
?>
    <div id="form-modifier" class="form01 ui form bg-color">
        <div class="photo"><input type="file" style="display:none" id="mPhoto" >
            <img src="../Photos/<?=$employe['photoEmploye'];?>" alt="Ajouter" id="mAdd-photo">
            <input type="file" name="photo" style="display:none" id="mPhoto">
        </div>
        <div class="leftEmployeForm">
            <div class="ajouter-label">
                <h4>Modifier<b class="sexeLbl"></b> employé<b class="sexeLbl"></b></h4>
            </div>
            <div class="info-employes">
                <div class="employeFlexBox">
                    <input type="text" id="mNom" required placeholder="Nom employé" value="<?=$employe['nomEmploye'];?>">
                    <input type="text" id="mPrenom" required placeholder="Prenom employé" value="<?=$employe['prenomEmploye'];?>">
                </div>
                <div class="employeFlexBox">
                    <input type="text" id="mAdresse" required placeholder="Adresse employé" value="<?=$employe['adresseEmploye'];?>">
                    <input type="number" id="mNumero" min=10 required placeholder="Numero employé" value="<?=$employe['numeroEmploye'];?>">
                </div>
                <div class="employeFlexBox">
                    <div class="employeFlexBoxDiv">
                        <label class="ui label" for="mEmbauche">Date d'embauche</label>
                        <input type="date" id="mEmbauche" min="2000-01-01" max="<?= date("Y-m-d"); ?>" value="<?=$employe['dateDEmbauche'];?>">
                    </div>
                    <div class="employeFlexBoxDiv">
                        <label class="ui label" for="sexe">Sexe employé<b class="sexeLbl"></b></label>
                        <select id="mSexe">
                            <option value="M">Masculin</option>
                            <option value="F" <?php if ($employe['sexeEmploye'] == 'F') { echo "selected"; } ?>>Feminin</option>
                        </select>
                    </div>
                </div>
                <div class="employeFlexBox departement">
                    <label for="mDepartement" class="ui label">Département de l'employé<b class="sexeLbl"></b></label>
                    <select id="mDepartement">
                    <?php
                    foreach ($departement as $depart)
                    {
                        ?>
                        <option value="depart<?= $depart['idDepartement']; ?>" <?php if ($depart['idDepartement'] == $employe['departEmploye']) {echo "selected";} ?>><?= $depart['nomDepartement']; ?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="mButton">
            <button class="ui red button">Annuler</button>
            <button class="ui blue button" id="button<?=$employe['idEmploye'];?>" disabled>Modifier</button>
        </div>
    </div>
    <script>
        $("#mPhoto").change(function(){
            $(".mButton .ui.button.blue").removeAttr('disabled')
        })
        $(".mButton .ui.button.red").click(function(){
            mClose()
        })
        $("#mAdd-photo").click(function(){
            $("#mPhoto").click();
        })
        $("#mPhoto").change(function(){
            var img = document.getElementById("mPhoto")
            const [file] = img.files
            if (file) {
                var url = URL.createObjectURL(file)
                $("#mAdd-photo").attr('src',url)
            }
        })
        $("#mSexe").change(function(){
            const sexe = $(this).val()
            if (sexe == 'F')
            {
                $(".sexeLbl").text('e')
                $("#mNom").attr('placeholder',"Nom employée")
                $("#mPrenom").attr('placeholder',"Prénom employée")
                $("#mAdresse").attr('placeholder',"Adresse employée")
                $("#mNumero").attr('placeholder',"Numéro employée")
                const photo = $("#mAdd-photo").attr("src")
                if (photo == "../Photos/user-profile.png")
                {
                    $("#mAdd-photo").attr("src", "../Photos/user-profile-woman.png")
                }
            } else {
                $(".sexeLbl").text("")
                $("#mNom").attr('placeholder',"Nom employé")
                $("#mPrenom").attr('placeholder',"Prénom employé")
                $("#mAdresse").attr('placeholder',"Adresse employé")
                $("#mNumero").attr('placeholder',"Numéro employé")
                const photo = $("#mAdd-photo").attr("src")
                if (photo == "../Photos/user-profile-woman.png")
                {
                    $("#mAdd-photo").attr("src", "../Photos/user-profile.png")
                }
            }
            enableBtn()
        })
        function enableBtn()
        {
            const data = {
                nom: ($("#mNom").val()).trim(),
                prenom: ($("#mPrenom").val()).trim(),
                adresse: ($("#mAdresse").val()).trim(),
                numero: ($("#mNumero").val()).trim(),
                sexe: $("#mSexe").val(),
                embauche: $("#mEmbauche").val(),
                departement: ($("#mDepartement").val()).substr(6)
            }
            if (data['nom'] != "<?= $employe['nomEmploye']; ?>" || data['prenom'] != "<?= $employe['prenomEmploye']; ?>" || data['adresse'] != "<?= $employe['adresseEmploye']; ?>" || 
                data['sexe'] != "<?= $employe['sexeEmploye']; ?>" || data['numero'] != "<?= $employe['numeroEmploye']; ?>" || data['embauche'] != "<?= $employe['dateDEmbauche']; ?>" ||
                data['departement'] != "<?= $employe['departEmploye']; ?>")
                {
                    $(".mButton .ui.button.blue").removeAttr('disabled')
                } else {
                    $(".mButton .ui.button.blue").attr('disabled', 'true')
                }
        }
        $("#form-modifier input").keyup(function(){ 
            // console.log("this")
            enableBtn()
        })
        $(".mButton .ui.button.blue").click(function(){
            var id = this.id
            const files = $("#mPhoto")[0].files
            id = id.substr(6)
            const data = {
                id: (this.id).substr(6),
                nom: ($("#mNom").val()).trim(),
                prenom: ($("#mPrenom").val()).trim(),
                adresse: ($("#mAdresse").val()).trim(),
                numero: ($("#mNumero").val()).trim(),
                sexe: $("#mSexe").val(),
                embauche: $("#mEmbauche").val(),
                departement: ($("#mDepartement").val()).substr(6)
            }
            console.log(data)
            if (data['nom'].length > 4)
            {
                
                if (data['adresse'].length > 10)
                {
                    if (data['numero'].length >= 10)
                    {
                        if (data['nom'] != "<?= $employe['nomEmploye']; ?>" || data['prenom'] != "<?= $employe['prenomEmploye']; ?>" || data['adresse'] != "<?= $employe['adresseEmploye']; ?>" || 
                        data['sexe'] != "<?= $employe['sexeEmploye']; ?>" || data['numero'] != "<?= $employe['numeroEmploye']; ?>" || data['embauche'] != "<?= $employe['dateDEmbauche']; ?>" ||
                        data['departement'] != "<?= $employe['departEmploye']; ?>")
                        {
                            var formData = new FormData()
                            formData.append('id',data['id'])
                            formData.append('nom',data['nom'])
                            formData.append('prenom',data['prenom'])
                            formData.append('adresse',data['adresse'])
                            formData.append('numero',data['numero'])
                            formData.append('embauche',data['embauche'])
                            formData.append('departement',data['departement'])
                            formData.append('sexe',data['sexe']),
                            formData.append('img',files[0])
                            $.ajax({
                                url: 'Traitements/modEmployeOp.php',
                                type: 'post',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success:function(response)
                                {
                                    console.log(response)
                                    if(response=='done'){
                                        mClose()
                                        afficheData()
                                        notification("Employé modifié avec succès")
                                    } else {
                                        notification("Il y a une erreur lors de la modification")
                                    }
                                }
                            })
                        } else {
                            var formData = new FormData()
                            formData.append('id',data['id'])
                            formData.append('img',files[0])
                            $.ajax({
                                url: 'Traitements/modEmployeOp.php',
                                type: 'post',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success:function(response)
                                {
                                    console.log(response)
                                    if(response=='done'){
                                        mClose()
                                        afficheData()
                                        notification("Photo modifié avec succès")
                                    } else {
                                        notification("Il y a une erreur lors de la modification")
                                    }
                                }
                            })
                        }
                    }
                } else {
                    notification("Adresse trop court")
            }
            } else {
                notification("Nom trop court")
            }
        })
    </script>
    <?php
    }
?>