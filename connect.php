<?php

Global $db;

$dbname = "weatherstorage";
$username = "root";
$password = "";

    $db = new PDO('mysql:dbname='.$dbname.';host=localhost', ''.$username.'', ''.$password.'');


?>