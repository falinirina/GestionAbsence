<?php
    if (isset($_POST['result']))
    {
        require_once "../../timezone.php";
        $result = htmlspecialchars($_POST['result']);
        $date = date_create();
        if ($result == 'h')
        {

            echo date_format($date,'H');
        } else if ($result == 'm')
        {
            echo date_format($date,'i');
        }
    }

?>