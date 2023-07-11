<?php
    session_start();
    if (isset($_SESSION['administrateur']) && isset($_POST['matin']) && isset($_POST['id']) && isset($_POST['date']) && isset($_POST['nom']))
    {
        require_once "./getDate.php";
        $dateC = date_create($_POST['date']);
        $fullDateText = dateTraitement::fullDate($dateC);
        if ($_POST['matin'] == "oui")
        {
            ?>
            <div class="bg-color">
                <div class="title">
                    <h4><?= $fullDateText; ?></h4>
                </div>
                <div class="top2"><?= $_POST['nom'] ?></div>
                <div class="ui form">
                    <label class="ui label" for="sortie">Sortie</label>
                    <div id="sortie">
                        <input type="number" id="shour" min="10" max="12" value="12">:<input type="number" id="smin" min="0" max="59" value="0">
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
                <div class="title">
                    <h4><?= $fullDateText; ?></h4>
                </div>
                <div class="top2"><?= $_POST['nom'] ?></div>
                <div class="ui form">
                    <label class="ui label" for="sortie">Sortie</label>
                    <div id="sortie">
                        <input type="number" id="shour" min="16" max="21" value="18">:<input type="number" id="smin" min="0" max="59" value="0">
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
            function sendThis()
            {
                $.post("Traitements/addSortie.php", {
                    id: '<?= $_POST['id'] ?>',
                    date: '<?= $_POST['date'] ?>',
                    sortie: [$("#shour").val(),$("#smin").val()],
                    matin: '<?= $_POST['matin']; ?>'
                }, function(data){
                    // console.log(data)
                    $("#addPresence").css("display", "none")
                    $("#addPresence").html("")
                    refreshView()
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