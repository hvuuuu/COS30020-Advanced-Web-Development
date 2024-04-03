<?php
    require_once("hitcounter.php");
    require_once("../../data/lab10/mykeys.inc.php");

    $counter = new HitCounter($host, $username, $password, $dbname);
    $counter->startOver();
    $counter->closeConnection();
?>