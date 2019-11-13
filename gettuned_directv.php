<?php
    $gettuned_url = 'http://'.$ip.':8080/tv/getTuned';
    $tuned = json_decode(file_get_contents($gettuned_url,true));
    ini_set('default_socket_timeout',5);
    //var_dump($tuned);
    $channel = 0;
    if (isset($tuned)){
    	if ($tuned->minor == 65535){
	        $channel = $tuned->major;
	    }
	    else {
	        $channel = $tuned->major.'.'.$tuned->minor;
	    }
	    if ($channel!=$dbTuned){
		error_log("$name has been tuned to $channel, ". $tuned->callsign . ".",0);
	    $db->query("UPDATE tuners SET tuned = $channel WHERE serialNum = \"$box_serial\"");
	    }
    }
    else {
    	error_log("$name did not respond to gettuned query.",0);
    	$channel = NULL;
    	//$db->query("UPDATE tuners SET tuned = 0 WHERE serialNum = \"$box_serial\"");
    }
    
?>
