<?php
    $gettuned_url = 'http://'.$ip.':8080/tv/getTuned';
    $tuned = json_decode(file_get_contents($gettuned_url,true));
    
    if ($tuned->minor == 65535){
        $channel = $tuned->major;
    }
    else{
        $channel = $tuned->major.'.'.$tuned_minor;
    }
?>
