<style>
  a#nav-logo {
    font-family: algerian;
    margin-bottom: 25px;
  }
  #nav-logo>div:first-child{
    font-size: 25px;
    margin-left: 15px;
  }
  #nav-logo>div:last-child{
    margin-left: 60px;
  }
</style>
<div class="bg-color" id="notification">
  <div class="topToast">Notification</div>
  <div id="messageToast"></div>
</div>
<div id="cmdp">
</div>
<div id="deconnexDiv">
  <div class="bg-color">
    <p>Voulez-vous vraiment vous deconnecter</p>
    <div class="deconnexBtn">
      <button class="ui button green">Oui</button>
      <button class="ui button red">Non</button>
    </div>
  </div>
</div>
<nav class="w3-sidebar w3-bar-block w3-collapse w3-animate-left w3-card" id="mySidebar">
  <a class="w3-bar-item w3-button w3-border-bottom w3-large" id="nav-logo" href="#"><img src="../logo.png" alt="Logo Entreprise"></a>
  <a class="w3-bar-item w3-button w3-hide-large w3-large" href="javascript:void(0)" onclick="w3_close()">Close <i class="fa fa-remove"></i></a>
  <a class="w3-bar-item w3-button w3-teal">Gerer les employes</a>
  <a class="w3-bar-item w3-button">Retards et Absences</a>
  <a class="w3-bar-item w3-button" style="bottom: 54px;position: absolute;">Changer Mot de passe<i style="float: right;" class="ui icon key"></i></a>
  <a class="w3-bar-item w3-button" style="bottom: 0;position: absolute;">Deconnecter<i style="float: right;" class="ui icon logout"></i></a>
</nav>
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>
<div class="w3-main" style="margin-left:250px;padding: 15px;">

<div id="nav-pages">
  <table>
    <tr><td>Pages</td><td>/</td><td id="pageNow">Tableau de bord</td></tr>
    <tr><td id="pageNow2" colspan=3>Tableau de bord</td></tr>
  </table>
  <div class="nMode">
    <div>
      <i class="ui icon sun"></i>
    </div>
    <label class="switch">
      <input type="checkbox" id="dark">
      <span class="slider round"></span>
    </label>
    <div>
      <i class="ui icon moon"></i>
    </div>
  </div>
</div>
<script>
  <?php
    if ($_SESSION["darkMode"])
    {
      ?>
       $("#dark").prop("checked", true)
       <?php
    } else {
      ?>
      $("#dark").prop("checked", false)
      <?php
    }
  ?>
  var afficheNotif = null
  function notification(message)
  {
    clearTimeout(afficheNotif)
    $("#notification").css('display', 'none')
    $("#messageToast").text(message)
    $("#notification").css('display', 'flex')
    afficheNotif = setTimeout(notificationHide, 5000)
  }
  function notificationHide()
  {
    $("#notification").css('display', 'none')
  }

  $("#deconnexDiv .ui.button.red").click(function(){
    $("#deconnexDiv").css('display', 'none')
  })
  $("#deconnexDiv .ui.button.green").click(function(){
    deconnection()
  })
  $('#dark').click(function(){
    const check = $("#dark").prop("checked")
    if (check)
    {
      $("link[href='Styles/light.css']").attr("href","Styles/dark.css")
      $.post("Traitements/changeDarkMode.php", {dark: "on"},function (data){})
    } else {
      $("link[href='Styles/dark.css']").attr('href','Styles/light.css')
      $.post("Traitements/changeDarkMode.php", {dark: "off"},function (data){})
    }
  })
function changePage(getindex)
{
    console.log(getindex)
    if (getindex!=6 && getindex != 0 && getindex != 4 && getindex != 5)
    {
        $(".w3-bar-item.w3-button.w3-teal").attr("class","w3-bar-item w3-button")
        $(".w3-bar-item.w3-button:nth-child("+(getindex+1)+")").attr("class","w3-bar-item w3-button w3-teal")
    }
    // if (getindex == 2) {$.get("Pages/dashboard.php", function(data, status){$("#contenue").html(data)});}
    if (getindex == 2) {$.get("Pages/employes.php", function(data, status){$("#contenue").html(data)});}
    else if (getindex == 3) {$.get("Pages/retards.php", function(data, status){$("#contenue").html(data)});}
    // else if (getindex == 5) {$.get("Pages/absences.php", function(data, status){$("#contenue").html(data)});}
    else if (getindex == 4) { changeMdp() }
    else if (getindex == 5) {
      $("#deconnexDiv").css('display', 'flex')
    }
}
$(document).ready(function(){
    $(".w3-bar-item.w3-button").click(function(){
        var index = $(this).index()
        var classe = this.className
        if (classe != "w3-bar-item w3-button w3-teal") {changePage(index)}
    })
    $(".button-setting>.ui.red.button").click(function(){
        $("#bg-setting").css('display','none')
    })
    $(".button-setting2>.ui.red.button").click(function(){
        $("#bg-login").css('display','none')
    })
    
})
function changeMdp()
{
  $.post("Pages/passFormulaire.php", {},function (data){
    $("#cmdp").html(data)
    $("#cmdp").css('display','flex')
  })
}
function deconnection(){
  document.location = "Traitements/deconnection.php"
}
</script>
<style>
  .ui.icon.sun{
    font-size: 25px;
  }
  input + .slider {
    background-color: #d6df1e;
  }
</style>