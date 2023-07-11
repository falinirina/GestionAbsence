<?php
    class Employe
    {
        public static function default($bdd,$index=1)
        {
            $offset=($index==1?null:"OFFSET ".(($index - 1) * 6));
            $data=$bdd->query("SELECT * FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE NOT typeCompte='admin' LIMIT 6 $offset");
            return $data->fetchAll();
            
        }
        public static function dataCount($bdd,$filtre=null,$search=null)
        {
            if ($search!=null){
                $nbr=$bdd->query("SELECT * FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE  (nomEmploye LIKE '$search%' OR prenomEmploye LIKE '$search%') AND NOT typeCompte='admin'");
                return $nbr->rowCount();
            }
            $nbr=$bdd->query("SELECT count(*) FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE NOT typeCompte='admin' $filtre $search ");
            $nbr=$nbr->fetch();
            return $nbr[0];
        }
        public static function search($bdd,$word,$index=1)
        {
            $offset=($index ==1 ?null:"OFFSET ".(($index - 1) * 6));
            $data=$bdd->query("SELECT * FROM employe INNER JOIN departement ON employe.departEmploye=departement.idDepartement WHERE (nomEmploye LIKE '$word%' OR prenomEmploye LIKE '$word%') AND NOT typeCompte='admin' LIMIT 6 $offset");
            return $data->fetchAll();
        }
        public static function pages($bdd,$filtre=null,$search=null)
        {
            $nbr=Employe::dataCount($bdd,$filtre=null,$search);

            $page=$nbr/6;
            $nbrpage=($page <= ((int)$page)? ((int)$page) : ((int)$page) + 1);
            return $nbrpage;
        }

        public static function affiche($bdd,$data,$nbrpage,$index=1)
        {
            foreach ($data as $employe)
            {
                ?>
                <div class="employe bg-color">
                    <img src="../Photos/<?= $employe['photoEmploye'] ?>" alt="" class="employe-photo">
                    <div class="employeListLeft">
                        <div class="employe-top">
                            Identifiant: <?= $employe['idEmploye'] ?><br>
                            Username: <?= $employe['username'] ?><br>
                            Departement: <?= $employe['nomDepartement'] ?> <br>
                            Date d'embauche: <?= $employe['dateDEmbauche'] ?> 
                        </div>
                        <div class="employe-description">
                            Nom: <?= $employe['nomEmploye'] ?><br>
                            Prenoms: <?= $employe['prenomEmploye'] ?><br>
                            Adresse: <?= $employe['adresseEmploye'] ?><br>
                            Numero: <?= $employe['numeroEmploye'] ?><br>
                        </div>
                    </div>
                    <div class="iIcon">
                        <i class="ui icon edit" id="employe<?= $employe['idEmploye'] ?>"></i>
                        <i class="ui icon trash" id="demploye<?= $employe['idEmploye'] ?>"></i>
                        <i class="ui icon key" onclick="resetKey(<?= $employe['idEmploye'] ?>)"></i>
                    </div>
                </div>
                <?php
            }
            if ($nbrpage>1){
            ?>
            <div class="pagination">
                <a>&laquo;</a>
                <?php
                    for ($i=1;$i<=$nbrpage;$i++)
                    {
                        if ($index == $i) {echo "<a id='active'>$i</a>";}
                        else {echo "<a>$i</a>";}
                    }
                ?>
                <a>&raquo;</a>
            </div>
            <div id="maxPage" style="display: none;"><?= $nbrpage ?></div>
            <script>              
                $(".pagination > a").click(function(){
                    pages(this)
                })
                function pages(getelement)
                {
                var getid = $(getelement).attr("id")
                var active = parseInt($('#active').text())
                var index = $(getelement).text()
                if (getid != "active")
                {
                    if (index=="«")
                    {
                    if (active != 1) {change_pages(parseInt(active)-1)}
                    } 
                    else if (index=="»")
                    {
                    var maxPage = parseInt($("#maxPage").text())
                    if (active < maxPage)
                    {
                        change_pages(parseInt(active)+1)
                    }
                    } 
                    else {change_pages(index)}
                }
                }
                function change_pages(index)
                {
                $.post('Traitements/getEmploye.php',{index:index},function(data){
                    $('.cont-employes>.liste-employes').html(data)
                })
                }
            </script>
            <?php
            }
            ?>
            <script>
                $(".employe .ui.icon.edit").click(function(){
                    modify(this)
                })
                $(".employe .ui.icon.trash").click(function(){
                    id = this.id
                    var idEmploye=id.substr(8)
                    $.post('Traitements/delEmployeForm.php',{employe:idEmploye},function(data){
                        $('#delete').html(data)
                        $('#delete').css('display','flex')
                    })
                })
            </script>
            <?php
        }
    }
?>