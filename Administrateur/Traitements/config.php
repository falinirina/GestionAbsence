<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=employeProject', "root", "");
    }catch(Exception $e)
    {
        echo "Erreur de la connection a la base de donnee";
    }

?>