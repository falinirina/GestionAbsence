<?php
    session_start();
    if (isset($_SESSION['administrateur']))
    {
        header("Location: Administrateur/");
    } else if (isset($_SESSION['utilisateur'])) {
        header("Location: Connected/");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/Semantic_UI/semantic.css">
    <link rel="stylesheet" href="Styles/connecter.css">
    <title>Se Connecter</title>
</head>
<body>
    <style>
        #username::placeholder,#password::placeholder{color: grey;}
    </style>
    <div id="container">
        <form action="connection.php" class="ui form" method="post">
            <div id="card-sign">
                <h2><b>Site Web</b></h2>
            </div>
            <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required><br><br>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required><br><br>
            <button type="submit" class="ui button blue">Se connecter</button><br>
        </form>
    </div>

    <footer>
        <div>
            © <?php echo date('Y') ?>, made by
            <a href=""><b>Team 5</b></a>
            for a better web.
        </div>
    </footer>
</body>
</html>