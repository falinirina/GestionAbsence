<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=employeProject', "root", "");
        date_default_timezone_set("Indian/Antananarivo");
    }catch(Exception $e)
    {
        echo "Erreur de la connection a la base de donnee";
    }

?>