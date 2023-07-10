<?php
  if (!isset($_SESSION['administrateur'])) {
    session_start();
    if (isset($_SESSION['administrateur']))
    {
      require_once "../Traitements/config.php";
    }
  } else {
    require_once "Traitements/config.php";
  }
  $employe = $bdd->query("SELECT idEmploye ,nomEmploye, prenomEmploye, nomDepartement FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE NOT typeCompte='admin' LIMIT 5");
  $row = $employe->rowCount();
  $employe = $employe->fetchAll();
  $dateNow = date_create();
  $dateNow = date_format($dateNow, "Y-m-d");
?>
<div id="add-font"></div>
<div id="addPresence"></div>
<div id="verif-presence">
  <div class="bg-color" id="verifPresenceDiv">
    <div class="top">Verification des presences</div>
    <div class="search ui form">
      <div style="display: flex;align-items: stretch; flex-direction: row;">
        <label for="datePresence" class="ui label">Date</label>
        <input type="date" name="datePresence" id="datePresence" value="<?= $dateNow ?>" max="<?= $dateNow ?>">
      </div>
      <div>
        <button class="ui button blue">Search</button>

      </div>
    </div>
    <div id="resultPresence">
      Les resultats s'afficheront ici
    </div>
    <div style="display: flex;justify-content: flex-end;margin-top: 20px;">
      <button class="ui red button">Fermer</button>
    </div>
    <script>
      $("#verif-presence .ui.button.red").click(function (){
        $("#verif-presence").css("display", "none")
      })
      $("#verif-presence .ui.button.blue").click(function (){
        const date = $("#datePresence").val()
        $.post("Traitements/verifPresence.php", {date: date}, function(data){
          $("#resultPresence").html(data)
        })
      })
    </script>
  </div>
</div>
<div class="filtre-retard">
  <button class="ui button" onclick="afficherPresence()">Verification Presence</button>
</div>
<div class="cont-employesFilter">
  <div class="listeEmpFilter bg-color">
    <div class="empFilter ui form">
      <input type="text" name="search" onkeyup="searchLaunch()" placeholder="Taper ici" id="searchEmpl" >
      <script>
        function searchLaunch()
        {
          const search = ($("#searchEmpl").val()).trim()
          $.post("Traitements/rechercheEmploye.php", {search: search}, function(data){
            $("#tableRes").html(data)
          })
        }
      </script>
    </div>
    <?php
      if ($row > 0)
      {
        ?>
        <table class="ui table" id="tableRes">
          <?php
            foreach ($employe as $data)
            {
              ?>
               <tr>
                <td onclick="viewEmploye('<?= $data['idEmploye']; ?>')"><?= $data['nomEmploye']."<br>".$data['prenomEmploye']; ?></td>
              </tr>
              <?php
            }
          ?>
        </table>
        <?php

      } else {
        ?>
        <div>Pas de donnée</div>
        <?php
      }
    ?>
  </div>
  <div class="leftInformation bg-color" id="leftInformation">
    <div class="selectUser"><h3>Selectionner un employé pour voir les informations</h3></div>
  </div>
</div>
<script>
  $("#pageNow").text("retards et absences")
  $("#pageNow2").text("Gerer les retards et absences")
  function viewEmploye(getId)
  {
    const id = getId
    $.post("Traitements/retardInfoShow.php", {id: id}, function (data){
      $("#leftInformation").html(data)
    })
  }
  function refreshView()
  {
    const date = $("#datePresence").val()
    $.post("Traitements/verifPresence.php", {date: date}, function(data){
      $("#resultPresence").html(data)
    })
  }
  function afficherPresence()
  {
    $("#verif-presence").css('display', 'flex')
  }
</script>