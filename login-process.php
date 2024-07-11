<?php

    include("connect.php");

    $icnum = isset($_POST['icnum']) ? $_POST['icnum'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $sql = "SELECT * FROM staff WHERE staffid = :staffid";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":staffid", $icnum);

    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    if($row)
    {
        $hash_password = $row['password'];

        if (password_verify($password, $hash_password))
        {
            session_start();

            $_SESSION['icnum'] = $row['staffid'];
            header("locations: client-homepage.html");
        }
        else
        {
            echo "Invalid email or password";
        }
    }

    oci_close($conn);

?>