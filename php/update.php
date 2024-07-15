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

        $sql = "SELECT * FROM book_reps WHERE ISBN:=ISBN";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":ISBN", $isbn);

        oci_execute($stmt);

        if($row = oci_fetch_array($stmt, OCI_ASSOC))
        {
            $isbn = $row['ISBN'];
            $book_title = $row['BOOK_NAME'];
            $genre = $row['GENRE'];

            ?>
                <div>
                    <p>ISBN: <?php echo $isbn ?></p>
                    <p>Title: <?php echo $book_title ?></p>
                    <p>Genre: <?php echo $genre ?></p>
                </div>
            <?php
        }
        else
        {
            header("location: inventory.php");
            exit;
        }
    }
?>