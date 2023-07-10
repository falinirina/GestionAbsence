<?php
    require_once 'config.php';
    require_once '../Classes/Employe.php';

    if(isset($_POST['filtre']) || isset($_POST['search']))
    {
        $word = htmlspecialchars($_POST['search']);
        if ($word==""){initial($bdd);}
        else{
            search($bdd,$word);
        }
    } else {
        $nbrdata=Employe::dataCount($bdd);
        if($nbrdata==0){echo nodata();}
        else{initial($bdd);}
    }

    function nodata()
    {
        return "<div class='result'>NO DATA</div>";
    }

    function initial($bdd)
    {
        $nbrpage=Employe::pages($bdd);
        $index=1;
        if (isset($_POST['index']))
        {
            $index=htmlspecialchars($_POST['index']);
            $ecoles=Employe::default($bdd,$index);
        } else {
            $ecoles=Employe::default($bdd);
        }
        Employe::affiche($bdd,$ecoles,$nbrpage,$index);
    }
    function search($bdd,$word)
    {
        $nbrpage=Employe::pages($bdd,null,$word);
        $index=1;
        $ecoles=Employe::search($bdd,$word);
        Employe::affiche($bdd,$ecoles,$nbrpage,$index);

    } 

?>