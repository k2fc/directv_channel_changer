<?php
$channel = $_POST['channel'];
$ip = $_POST['ip'];

if (strpos($channel,'-')!== false){

    $channelparts = explode("-",2);
    $major = sanitizeInput($channelparts[1]);
    $minor = sanitizeinput($channelparts[2]);
    $dinettes = file_get_contents("http://$ip:8080/tv/tune?major=$major&minor=$minor");
}
elseif (strpos($channel,'.')!== false){
    $channelparts = explode(".",2);
    $major = sanitizeInput($channelparts[1]);
    $minor = sanitizeinput($channelparts[2]);
    $dinettes = file_get_contents("http://$ip:8080/tv/tune?major=$major&minor=$minor");
}
else{
    $major = sanitizeInput($channel);
    $dinettes = file_get_contents("http://$ip:8080/tv/tune?major=$major");
}
echo($dinettes);
sleep(4);
header("Location: index.php"); /* Redirect browser */
exit();

function sanitizeInput($string) { return preg_replace("[^0-9]", "", $string); }
?>
