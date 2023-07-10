<div class="bg-color" id="sortirForm">
    <p>Etes-vous sur de vouloir sortir</p>
    <div class="button">
        <button class="ui button green">Oui</button>
        <button class="ui button red">Non</button>
    </div>
</div>
<script>
    $("#sortirForm .ui.green.button").click(function(){
        $.post("Traitements/pointagePresence.php", {
            action: "sortie"
        }, function (data){
            if (data == "done")
            {
                $("#cmdp").css('display', 'none')
                checkPresence();
            }
        })
    })
    $("#sortirForm .ui.button.red").click(function(){
        $("#cmdp").html("")
        $("#cmdp").css('display', 'none')
    })
</script>