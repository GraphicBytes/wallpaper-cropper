<?php
function lastactive($unix)
{
    $datetime1 = new DateTime(date("Y-m-d H:i:s", $unix));
    $datetime2 = new DateTime();
    $interval = $datetime1->diff($datetime2);

    $compare= time() - $unix;

    if($compare < 60) {return "Online now";}
    else if($compare > 60 && $compare < 3600) {return $interval->format('Last seen %I minutes ago ');}
    else if($compare > 3600 && $compare < 7200) {return $interval->format('Last seen %H hour ago ');}
    else if($compare > 7200 && $compare < 86400) {return $interval->format('Last seen %H hours ago ');}
    else if($compare > 86400 && $compare < 172800) {return $interval->format('Last seen %a day ago ');}
    else if($compare > 172800) {return $interval->format('Last seen %a days ago ');}
    }
?>
