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

        $sql = "SELECT * FROM book_reps WHERE ISBN=:ISBN";
        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stdi, ":ISBN", $isbn);

        oci_execute($stid);

        // Fetch the result
        if($row = oci_fetch_array($stid, OCI_ASSOC)) 
        {
            $row = oci_fetch_assoc($stid);
        } 
        else 
        {
            // No rows found, redirect to inventory
            header("Location: inventory.php");
            exit;
        }
    }
?>