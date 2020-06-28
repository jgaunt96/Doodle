<?php

ob_start();

try {

    // $con = new PDO("mysql:dbname=doodle;host=localhost", "root", "");
    $con = new PDO("mysql:dbname=doodle:host=//eu-cdbr-west-03.cleardb.net/heroku_c20b2a94ec09272?reconnect=true", "b5d738cb55e2b2:95108ea6", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    echo "Connection failed " . $e->getMessage();
}

?>

<!-- mysql://b5d738cb55e2b2:95108ea6@eu-cdbr-west-03.cleardb.net/heroku_c20b2a94ec09272?reconnect=true -->