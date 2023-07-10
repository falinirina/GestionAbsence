<div id="form-ajouter" class="form01 ui form bg-color">
    <div class="photo"><input type="file" name="photo" style="display:none" id="photo"><img src="../Photos/user-profile.png" alt="Ajouter" id="add-photo"></div>
    <div class="leftEmployeForm">
        <div class="ajouter-label">
            <h4>Ajouter un<b class="sexeLbl"></b> employé<b class="sexeLbl"></b></h4>
        </div>
        <div class="info-employes">
            <div class="employeFlexBox">
                <input type="text" name="nom" id="nom" required placeholder="Nom employé">
                <input type="text" name="prenom" id="prenom" required placeholder="Prenom employé">
            </div>
            <div class="employeFlexBox">
                <input type="text" name="adresse" id="adresse" required placeholder="Adresse employé">
                <input type="number" name="numero" id="numero" min=10 required placeholder="Numero employé">
            </div>
            <div class="employeFlexBox">
                <div class="employeFlexBoxDiv">
                    <label class="ui label" for="embauche">Date d'embauche</label>
                    <input type="date" name="embauche" id="embauche" min="2000-01-01" max="<?= date("Y-m-d"); ?>" value="<?= date("Y-m-d"); ?>">
                </div>
                <div class="employeFlexBoxDiv">
                    <label class="ui label" for="sexe">Sexe employé<b class="sexeLbl"></b></label>
                    <select name="sexe" id="sexe">
                        <option value="M" selected>Masculin</option>
                        <option value="F">Feminin</option>
                    </select>
                </div>
            </div>
            <div class="employeFlexBox departement">
                <label for="departement" class="ui label">Département de l'employé<b class="sexeLbl"></b></label>
                <select name="departement" id="departement"></select>
            </div>
        </div>
    </div>
    <div id="resultatop"></div>
    <div>
      <button class="ui red button">Annuler</button>
      <button class="ui blue button">Ajouter</button>
    </div>
</div>
<script>
    function departementInit()
    {
        $.post("Traitements/getDepartement.php", {typeResultat: "select"}, function(data){
            $("#departement").html(data)
        })
    }
    $("#sexe").change(function(){
        const sexe = $(this).val()
        if (sexe == 'F')
        {
            $(".sexeLbl").text('e')
            $("#nom").attr('placeholder',"Nom employée")
            $("#prenom").attr('placeholder',"Prénom employée")
            $("#adresse").attr('placeholder',"Adresse employée")
            $("#numero").attr('placeholder',"Numéro employée")
            $("#add-photo").attr("src", "../Photos/user-profile-woman.png")
        } else {
            $(".sexeLbl").text("")
            $("#nom").attr('placeholder',"Nom employé")
            $("#prenom").attr('placeholder',"Prénom employé")
            $("#adresse").attr('placeholder',"Adresse employé")
            $("#numero").attr('placeholder',"Numéro employé")
            $("#add-photo").attr("src", "../Photos/user-profile.png")
        }
    })
    departementInit()
    $("#add-photo").click(function(){
        $("#photo").click();
    })
    $("#photo").change(function(){
        var img = document.getElementById("photo")
        const [file] = img.files
        if (file) {
            var url = URL.createObjectURL(file)
            $("#add-photo").attr('src',url)
        }
    })
    $("#form-ajouter button:first-child").click(function(){
        $("#add-font").css('display','none')
    })

    $("#add-font>div>div>button:last-child").click(function(){
        const files = $("#photo")[0].files
        const data = {
            nom: ($("#nom").val()).trim(),
            prenom: ($("#prenom").val()).trim(),
            adresse: ($("#adresse").val()).trim(),
            numero: ($("#numero").val()).trim(),
            sexe: $("#sexe").val(),
            embauche: $("#embauche").val(),
            departement: ($("#departement").val()).substr(6),
            img: $("#add-photo").attr('src')
        }
        if (data['nom'].length > 4)
        {
            
            if (data['adresse'].length > 10)
            {
                if (data['numero'].length >= 10)
                {
                    var formData = new FormData()
                    formData.append('img',files[0])
                    formData.append('nom',data['nom'])
                    formData.append('prenom',data['prenom'])
                    formData.append('adresse',data['adresse'])
                    formData.append('numero',data['numero'])
                    formData.append('embauche',data['embauche'])
                    formData.append('departement',data['departement'])
                    formData.append('sexe',data['sexe'])
                    $.ajax({
                        url: 'Traitements/addEmploye.php',
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success:function(response)
                        {
                            if(response=='done'){
                                $("#add-font").css('display','none')
                                afficheData();
                                $("#add-font").html('')
                                notification("Employé ajouter avec succès")
                            } else {
                                notification("Cette employe existe déjà dans la base de donnée")
                            }
                        }
                    })
                } else {
                    $("#numero").focus()
                    notification("Numero incorrect")
                }
            } else {
                $("#adresse").focus()
                notification("Adresse trop court")
            }
        } else {
            $("#nom").focus()
            notification("Nom trop court")
        }
    })
</script>