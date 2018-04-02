<?php
$ip = $_POST['ip'];
$requester = $_POST['requester'];
$boxname = $_POST['name'];
error_log("User at $requester requested reboot of $boxname",0);

$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=poweroff");
error_log("Tuner at $ip responded ". $status["code"].": ". $status["msg"],0);


sleep(3);

$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=poweron");
error_log("Tuner at $ip responded ". $status["code"].": ". $status["msg"],0);
sleep(2);

header("Location: index.php"); /* Redirect browser */
exit();

?>
