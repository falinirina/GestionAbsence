<?php
    require_once "Traitements/getDate.php";
    $newDate = date_create();
    $fullDateText = dateTraitement::fullDate($newDate);
?>
<div id="deconnexDiv">
  <div class="bg-color">
    <p>Voulez-vous vraiment vous deconnecter</p>
    <div class="deconnexBtn">
      <button class="ui button green">Oui</button>
      <button class="ui button red">Non</button>
    </div>
  </div>
</div>
<div class="content">
    <nav>
        <div>Module Utilisateur</div>
        <div class="iIcon">
            <div class="dark">
                <div style="margin-top: 10px;"><i class="icon ui moon"></i></div>
                <label class="switch">
                    <input id="darkMode" type="checkbox" <?php if (isset($_SESSION['pInfo']['dark'])) 
                    {
                        if ($_SESSION['pInfo']['dark'] == 'on') echo "checked";
                    } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div style="margin-top: 10px;"><i class="ui icon logout"></i></div>
        </div>
    </nav>
    <div id="left">
       
        <div id="time2">
            <div class="ui label" style="width: 440px;font-size: 25px;">
                <?= $fullDateText;?>
            </div>
            <div id="clock">
                <div id="time">
                    
                    <div><span id="hours"><?= date_format($newDate, "H"); ?></span><span>Heures</span></div>
                    <div><span id="minutes"><?= date_format($newDate, "i"); ?></span><span>Minutes</span></div>
                </div>
            </div>
        </div>
        <div id="presenceCont"></div>
    </div>
    <div id="right" class="bg-color">
        <div class="top">
            <div class="info">
                <div class="photo"><img src="../Photos/<?=$_SESSION['infoUtilisateur']['photo'];?>"></i></div>
                <hr>
                <div class="mProfil">Mon Profil</div>
                <table>
                    <tr><td>Nom:</td><td><?=$_SESSION['infoUtilisateur']['nom'];?></td></tr>
                    <tr><td>Prenoms:</td><td><?=$_SESSION['infoUtilisateur']['prenom'];?></td></tr>
                    <tr><td>Adresse:</td><td><?=$_SESSION['infoUtilisateur']['adresse'];?></td></tr>
                    <tr>
                        <td>Sexe:</td>
                        <td><?php
                            $sexe=($_SESSION['infoUtilisateur']['sexe'] == 'M' ? "Masculin" : "Feminin");
                            echo $sexe;
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <hr>
        <div class="bottom">
            <div>Compte</div>
            <table>
                <tr><td>Username:</td><td><?=$_SESSION['utilisateur'];?></td></tr>
                <tr><td>Changer le mot de passe</td><td><i class="ui icon key"></i></td></tr>
            </table>
        </div>
    </div>

</div>
<div id="cmdp"></div>

<script>
    <?php
    if ($_SESSION['infoUtilisateur']['darkMode'])
    {
      ?>
       $("#darkMode").prop("checked", true)
       <?php
    } else {
      ?>
      $("#darkMode").prop("checked", false)
      <?php
    }
  ?>
  $("#deconnexDiv .ui.button.red").click(function(){
    $("#deconnexDiv").css('display', 'none')
  })
  $("#deconnexDiv .ui.button.green").click(function(){
    deconnection()
  })
  function deconnection(){
    document.location = "Traitements/deconnecter.php"
    }
    function checkPresence()
    {
        $.post("Traitements/checkPresence.php",{},function(data){
            $('#presenceCont').html(data)
        })
    }
    checkPresence();
    $(".ui.icon.key").click(function(){
        $.post("Pages/passFormulaire.php",{},function(data){
            $('#cmdp').html(data)
            $('#cmdp').css('display','flex')
        })
    })
    $(".ui.icon.logout").click(function(){
        $("#deconnexDiv").css('display', 'flex')
    })
    $('#darkMode').click(function(){
        const check = $("#darkMode").prop("checked")
        console.log(check)
        if (check)
        {
            $("link[href='Styles/light.css']").attr("href","Styles/dark.css")
            $.post("Traitements/changeDarkMode.php", {dark: "on"},function (data){})
        } else {
            $("link[href='Styles/dark.css']").attr('href','Styles/light.css')
            $.post("Traitements/changeDarkMode.php", {dark: "off"},function (data){})
        }
    })
    function clock()
    {
        $.post("Traitements/getHour.php", {result: 'h'}, function(data){
            $("#hours").html(data)
        })
        $.post("Traitements/getHour.php", {result: 'm'}, function(data){
            $("#minutes").html(data)
        })
    }
    var interval = setInterval(clock, 2000);
</script>
<style>
    #add-photo {
        width: 194px;
        height: 194px;
        margin-top: -6px;
        border-radius: 15px;
    }
    #alert .photo {
        max-width: 200px;
    background: linear-gradient(
45deg
, #00bcd4, #2b8c98);
    min-width: 200px;
    /* min-height: 200px; */
    height: 200px;
    /* margin-top: -70px !important; */
    border-radius: 15px;
    display: flex;
    align-content: center;
    align-items: center;
    justify-content: center;
    }
    #alert .photo>img{
        width: 190px;
    }
    #alert h5{
        width: 100%;
        text-align: center;
    }
    .edt{
        width: 98%;
        padding:10px;
    }
    .ui.icon{
    cursor:pointer;
    }
    .dark{
        display: flex;
    align-items: center;
    margin-right: 25px;
    }
    .ui.icon:hover{
        color:#009688;
    }
    .lbutton{
    display: flex;
    justify-content: space-between;
    }
    #cmdp>div,#cpro>div,#cPhoto>div{
        padding: 10px;
    height: 300px;
    display: flex;
    width: 350px;
    flex-direction: column;
    justify-content: space-around;
    }
    #alert>div{
        width: 500px;
        padding: 10px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    height: 330px;
    }
    #cmdp,#cpro,#alert{
    width: 100%;
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #00000087;
    height: 100%;
    overflow-y: auto;
    }
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.iIcon{
    display: flex;
    align-items: center;
    flex-direction: row;
}
nav .ui.icon{
    font-size: 30px;
}
</style>