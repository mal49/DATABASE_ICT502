<?php 
    if(isset($_GET['id']))
    {
        include("connect.php");
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $isbn = validate($_GET['id']);

        $sql = "SELECT * FROM book_reps WHERE ISBN=$isbn";
        $stid = oci_parse($conn, $sql);

        oci_execute($stid);

        if(oci_num_rows($stid) > 0)
        {
            $row = oci_fetch_assoc($stid);
        }
        else
        {
            header("location: inventory.php");
        }
    }
    else
    {
        header("location: inventory.php");
        exit;
    }
?>