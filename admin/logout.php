<?php
session_start();
session_unset();
session_destroy();
$url = '/pinkping/index.php';
header("Location:$url");
die();