<?php
    class dateTraitement
    {
        public static function convertJour($getJour)
        {
            if ($getJour == "Monday") return "Lundi";
            else if ($getJour == "Tuesday") return "Mardi";
            else if ($getJour == "Wednesday") return "Mercredi";
            else if ($getJour == "Thursday") return "Jeudi";
            else if ($getJour == "Friday") return "Vendredi";
            else if ($getJour == "Saturday") return "Samedi";
            else if ($getJour == "Sunday") return "Dimanche";
        }
        public static function convertMois($getMois)
        {
            if ($getMois == 1) return "Janvier";
            else if ($getMois == 2) return "Fevrier";
            else if ($getMois == 3) return "Mars";
            else if ($getMois == 4) return "Avril";
            else if ($getMois == 5) return "Mai";
            else if ($getMois == 6) return "Juin";
            else if ($getMois == 7) return "Juillet";
            else if ($getMois == 8) return "Aout";
            else if ($getMois == 9) return "Septembre";
            else if ($getMois == 10) return "Octobre";
            else if ($getMois == 11) return "Novembre";
            else if ($getMois == 12) return "Decembre";
        }
        public static function fullDate($date)
        {
            $year = date_format($date, "Y");
            $day = date_format($date,'l');
            $dayMounth = date_format($date,'d');
            $day = dateTraitement::convertJour($day);
            $mounth = date_format($date, 'n');
            $mounth = dateTraitement::convertMois($mounth);
            return $day." ".$dayMounth." ".$mounth." ".$year;
        }
    }


?>