<div class="bg-color ui form">
    <h4>Changer le mot de passe</h4>
    <input type="password" id="aPass" placeholder="Ancien mot de passe">
    <input type="password" id="nPass" placeholder="Nouveau mot de passe">
    <input type="password" id="cPass" placeholder="Confirmer mot de passe">
    <div class="lbutton">
        <button class="ui button blue" disabled>Confirmer</button>
        <button class="ui button red">Annuler</button>
    </div>
</div>
<script>
    $("#cmdp .ui.button.red").click(function(){
        $("#cmdp").css('display','none')
        $("#cmdp").html('')
    })
    $(".bg-color.ui.form>input").keyup(function(){
        const aPass=$("#aPass").val()
        const nPass=$("#nPass").val()
        const cPass=$("#cPass").val()
        if (aPass.length > 4 && nPass.length > 4 && cPass.length > 4)
        {
            if (nPass != aPass || cPass != aPass)
            {
                if (nPass == cPass)
                {
                    $("#cmdp .ui.button.blue").removeAttr('disabled')
                } else {
                    $("#cmdp .ui.button.blue").attr('disabled', 'true')
                }
            } else {
                $("#cmdp .ui.button.blue").attr('disabled', 'true')
            }
        } else {
            $("#cmdp .ui.button.blue").attr('disabled','true')
        }
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
                        if(data == "done")
                        {
                            $("#cmdp").html()
                            $("#cmdp").css('display', 'none')

                            notification("Mot de passe changé avec succès")
                        } else {
                            notification("Verifier votre mot de passe")
                        }
                    })
                }
            }
        }
    })
</script>