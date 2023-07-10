<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=employeProject', "root", "");
    }catch(Exception $e)
    {
        die('ERROR'.$e->getMessage());
    }

?>