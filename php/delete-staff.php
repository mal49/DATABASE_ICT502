<?php 
    include("connect.php");

    $errorMessage = "";
    $successMessage = "";

    $id = $staffid = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "" ;

        if(empty($id))
        {
            header("location: inventory.php");
            exit;
        }

        $sql = "SELECT * FROM staff WHERE STAFFID=:id";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $row = oci_fetch_assoc($stmt);

        if(!$row)
        {
            header("location: staff-list.php");
            exit;
        }

        $isbn = $row['STAFFID'];

    }
    elseif($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $id = isset($_POST['staffid']) ? $_POST['staffid'] : "" ;

        if(empty($id))
        {
            $errorMessage = "STAFF ID is required to delete the record!";
        }
        else
        {
            $sql = "DELETE FROM staff WHERE STAFFID=:id";
            $stmt = oci_parse($conn, $sql);

            oci_bind_by_name($stmt, ':id', $id);
            $result = oci_execute($stmt);

            if ($result) {
                $successMessage = "Record deleted successfully!";
            } else {
                $errorMessage = "Error deleting record!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
* {
    margin: 0;
    padding: 5px;
    box-sizing: border-box;
    font-family: monospace, sans-serif;
    font-size: 15px;
}

.container button {
    margin-top: 10px;
    margin-left: 5px;
}

.container form {
    width: 500px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    margin-left: 30%;
}

.container a {
    margin-top: 10px;
}
</style>

<body>
    <div class="container">
        <h1 class="display-4 text-center">Delete Staff</h1>
        <form action="delete-staff.php" method="post">
        <?php if(!empty($successMessage)) { ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php } ?>
        <?php if(!empty($errorMessage)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php } ?>
            <a href="staff-list.php" type="button" class="btn btn-danger">To Homepage</a>
        </form>
    </div>
</body>

</html>
