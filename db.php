<?php
$db = new SQLite3('tuners.db');

$db->query("CREATE TABLE IF NOT EXISTS interfaces (Name Varchar, Address int, SubnetMask int, exclude int)");
$db->query("CREATE TABLE IF NOT EXISTS tuners (serialNum Varchar, name Varchar, address Int, tuned Varchar)");
$db->query("CREATE TABLE IF NOT EXISTS settings (setting Varchar, value Varchar)");

?>
