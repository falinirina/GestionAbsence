
<div id="modplusplus"></div>
<div class="filtre-employes">
  <div class="ajouterForm">
    <div id="ajouter"><i class="ui icon add circle"></i></div>
    <div id="ajouterDep"><button class='ui button'>Departement</button></div>
  </div>
  <div class="ui form" id="form-search">
    <button class="ui white button">
      <i class="ui icon search"></i>
    </button>
    <input type="text" name="search" placeholder="Recherche employé" id="search">
  </div>
</div>
<div class="cont-employes">
  <div class="liste-employes">
  </div>
</div>

<div id="modify"></div>
<div id="delete"></div>
<script src="Scripts/employes.js"></script>
<script>
  $("#pageNow").text("employés")
  $("#pageNow2").text("Gerer les employés")
</script>