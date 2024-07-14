<?php
    include("connect.php");
    $sql = "SELECT * FROM book_reps";
    $stid = oci_parse($conn, $sql);

    /*
    if(!$stid)
    {
        $e = oci_error($conn);
        echo "SQL parsing failed: " . htmlentities($e['message']);
        exit;
    }
    else
    {
        echo "<br>SQL parsing successful.<br>";
    }
    
    if(!oci_execute($stid))
    {
        $e = oci_error($stid);
        echo htmlentities($e['message']);
        exit;
    }
    */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: monospace, sans-serif;
            font-size: 15px;
        }
</style>
<body style="margin: 50px;">
    
    <h1>Book List</h1>
    <table class="table">
        <tr>
            <th>ISBN</th>
            <th>BOOK TITLE</th>
            <th>GENRE</th>
            <th>AUTHOR</th>
            <th>PUBLISHER</th>
            <th>PRICE</th>
            <th>STATUS</th>
            <th>ACTION</th>
        </tr>
        <?php
            oci_execute($stid);
            $row_count = 0;
            while($row = oci_fetch_array($stid, OCI_ASSOC))
            {
                echo '<tr>'; 
                echo "<form method='post' action = 'staff-edit.php'>";
                echo '<td>' . htmlentities($row['ISBN']) . '</td>';
                echo '<td>' . htmlentities($row['BOOK_NAME']) . '</td>';
                echo '<td>' . htmlentities($row['GENRE']) . '</td>';
                echo '<td>' . htmlentities($row['AUTHOR']) . '</td>';
                echo '<td>' . htmlentities($row['PUBLISHER']) . '</td>';
                echo '<td>$' . htmlentities($row['PRICE']) . '</td>';
                echo '<td>' . htmlentities($row['STATUS']) . '</td>';
                echo '<td> <a href="staff-edit.php?id='. htmlentities($row['ISBN']) .'" class="btn btn-success">Update</a> 
                           <a href="#" class="btn btn-danger">Delete</a> 
                      </td>';
                echo "</form>";
                echo '</tr>';
                $row_count++;
            }

            if($row_count == 0)
            {
                echo "<tr><td colspan = '5'> No books found.</td></tr>";
            }
        ?>
    </table>
</body>
</html>

<?php
    oci_free_statement($stid);
    oci_close($conn);
?>