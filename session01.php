<?php

session_start();

$sid = session_id();

echo $sid;

$_SESSION["name"] = "坂尻";
$_SESSION["age"] = 29;

?>