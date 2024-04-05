<?php

$hostname ="localhost";
$dbuserid="pinkping";
$dbpasswd="12345";
$dbname="pinkping";

$mysqli = new mysqli($hostname,$dbuserid,$dbpasswd,$dbname);

if ($mysqli->connect_error) {
        die('Connect Error :'.$mysqli->connect_error);
} 
?>