<?php

include("../config.php");

if(isset($_POST["src"])){
    $query = $con->prepare("UPDATE images SET broken = clicks + 1 WHERE imageUrl=:src");
    $query->bindParam(":src", $_POST["src"]);

    $query->execute();
}
else {
    echo "no link passed to page";
}

?>