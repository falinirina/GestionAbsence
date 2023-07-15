<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['matin']) && isset($_POST['id']) && isset($_POST['date']) && isset($_POST['nom']))
    {
        require_once "./config.php";
        require_once "./getDate.php";
        $dateC = date_create($_POST['date']);
        $fullDateText = dateTraitement::fullDate($dateC);
        if ($_POST['matin'] == "oui")
        {
            ?>
            <div class="bg-color">
                <div class="top"><?= $fullDateText; ?></div>
                <div class="top2"><?= $_POST['nom'] ?></div>
                <div class="ui form">
                    <label class="ui label" for="entree">Entree</label>
                    <div id="entree">
                        <input type="number" id="ehour" min="7" max="9" value="8">:<input type="number" id="emin" min="0" max="59" value="0">
                    </div>
                    <label class="ui label" for="sortie">Sortie</label>
                    <div id="sortie">
                        <input type="number" id="shour" min="10" max="12" value="12">:<input type="number" id="smin" min="0" max="59" value="0">
                    </div>
                    <div class="absent">
                        <button class="ui button red" onclick="absentThis()">Absent</button>
                    </div>
                </div>
                <div class="bottom">
                    <button class="ui green button" onclick="sendThis()">Ajouter</button>
                    <button class="ui red button" onclick="closeThis()">Annuler</button>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="bg-color">
                <div class="top"><?= $fullDateText; ?></div>
                <div class="top2"><?= $_POST['nom'] ?></div>
                <div class="ui form">
                    <label class="ui label" for="entree">Entree</label>
                    <div id="entree">
                        <input type="number" id="ehour" min="13" max="15" value="14">:<input type="number" id="emin" min="0" max="59" value="0">
                    </div>
                    <label class="ui label" for="sortie">Sortie</label>
                    <div id="sortie">
                        <input type="number" id="shour" min="16" max="21" value="18">:<input type="number" id="smin" min="0" max="59" value="0">
                    </div>
                    <div class="absent">
                        <button class="ui button red" onclick="absentThis()">Absent</button>
                    </div>
                </div>
                <div class="bottom">
                    <button class="ui green button" onclick="sendThis()">Ajouter</button>
                    <button class="ui red button" onclick="closeThis()">Annuler</button>
                </div>
            </div>
            <?php
        }
        ?>
        <script>
            function absentThis()
            {
                $.post("Traitements/addPresence.php", {
                    id: '<?= $_POST['id'] ?>',
                    date: '<?= $_POST['date'] ?>',
                    absent: 'oui',
                    matin: '<?= $_POST['matin']; ?>'
                }, function(data){
                    console.log(data)
                    if (data == "done")
                    {
                        $("#addPresence").css("display", "none")
                        $("#addPresence").html("")
                        notification("Employé a été marqué absent avec succès")
                        refreshView()
                    }
                })
            }
            function sendThis()
            {
                $.post("Traitements/addPresence.php", {
                    id: '<?= $_POST['id'] ?>',
                    date: '<?= $_POST['date'] ?>',
                    entree: [$("#ehour").val(),$("#emin").val()],
                    sortie: [$("#shour").val(),$("#smin").val()],
                    matin: '<?= $_POST['matin']; ?>'
                }, function(data){
                    if (data == "done")
                    {
                        $("#addPresence").css("display", "none")
                        $("#addPresence").html("")
                        notification("La présence a été ajouté avec succès")
                        refreshView()
                    }
                })
            }
            function closeThis()
            {
                $("#addPresence").css("display", "none")
                $("#addPresence").html("")
            }
        </script>
        <?php
    }
?>