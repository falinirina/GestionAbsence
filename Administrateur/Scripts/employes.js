$("#ajouter").click(function(){
  $.post('Traitements/getDepartement.php',{},function(data){
    console.log(data)
      if (data == "vide") {
          notification("Ajouter au moin un departement")
      } else {
          $.post("Traitements/addEmployeForm.php",{},function(data){
            $("#add-font").html(data)
            $("#add-font").css('display','flex')
          })
      }
  })
})
$("#ajouterDep>button").click(function(){
  $.post("Pages/departement.php",{},function(data){
    $("#add-font").html(data)
    $("#add-font").css('display','flex')
  })
})
afficheData()
function afficheData()
{
  $.post('Traitements/getEmploye.php',{},function(data){
    $('.cont-employes>.liste-employes').html(data)
  })
}
function change_pages_search(word)
{
  $.post('Traitements/getEmploye.php',{search:word},function(data){
    $('.cont-employes>.liste-employes').html(data)
  })
}
function modify(getelement)
{
    const id=getelement.id
    const idEmploye = id.substr(7)
    $.post('Traitements/modEmployeForm.php',{employe:idEmploye},function(data){
        $('#modify').html(data)
        $('#modify').css('display','flex')
    })
}


var wCountSearch = 0;
$("#search").keyup(function(){
  var word = $(this).val()
  word = word.trim()
  if (word.length > 0 || wCountSearch != 0)
  {
    change_pages_search(word)
  }
  wCountSearch = word.length
})
function mClose()
{
  $('#modify').html("")
  $('#modify').css('display','none')
  
}