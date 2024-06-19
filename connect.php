<?php

    $user = "KEKW";
    $pass = "system";
    $host = "localhost/xe";
    $conn = oci_connect($user, $pass, $host);

    if($conn)
    {
        echo "Connected to oracle database";
    }
    else
    {
        echo "Something went wrong";
    }

?>