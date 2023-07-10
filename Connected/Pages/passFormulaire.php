<div class="bg-color ui form">
    <h4>Changer le mot de passe</h4>
    <input type="password" id="aPass" placeholder="Ancien mot de passe">
    <input type="password" id="nPass" placeholder="Nouveau mot de passe">
    <input type="password" id="cPass" placeholder="Confirmer mot de passe">
    <div class="lbutton">
        <button class="ui button red">Annuler</button>
        <button class="ui button blue">Confirmer</button>
    </div>
</div>
<script>
    $("#cmdp .ui.button.red").click(function(){
        $("#cmdp").css('display','none')
        $("#cmdp").html('')
    })
    $("#cmdp .ui.button.blue").click(function(){
        var aPass=$("#aPass").val()
        var nPass=$("#nPass").val()
        var cPass=$("#cPass").val()
        if(aPass != '' && nPass != '' && cPass != '')
        {
            if(aPass != nPass)
            {
                if(nPass == cPass)
                {
                    $.post("Traitements/changePass.php",{aPass:aPass, nPass:nPass, cPass:cPass},function(data)
                    {
                        console.log(data)
                        if(data == "done")
                        {
                            document.location="Traitements/deconnecter.php"
                        }
                    })
                }
            }
        }
    })
</script>