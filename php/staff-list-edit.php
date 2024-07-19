<?php 
    include("connect.php");


    $errorMessage = "";
    $successMessage = "";

    $id = $staffid = $name = $email = $phonenumber = $role = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "" ;

        if(empty($id))
        {
            header("location: staff-list.php");
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

        $staffid = $row['STAFFID'];
        $name = $row['NAME'];
        $email = $row['EMAIL'];
        $phonenumber = $row['PHONE_NUM'];
        $role = $row['ROLE'];
    }
    elseif($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $staffid = $_POST['staffid'];
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : "";
        $role = isset($_POST['role']) ? $_POST['role'] : "";

        $sql = "UPDATE staff SET EMAIL=:email,
                                 PHONE_NUM=:phonenumber,
                                 ROLE =:role
                                 WHERE STAFFID=:id";
                                     
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':email', $email);
        oci_bind_by_name($stmt, ':phonenumber', $phonenumber);
        oci_bind_by_name($stmt, ':role', $role);
        oci_bind_by_name($stmt, ':id', $staffid);

        $result = oci_execute($stmt);

        if ($result) {
            $successMessage = "Record updated successfully!";
        } else {
            $errorMessage = "Error updating record!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Staff</title>
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
        <h1 class="display-4 text-center">Update Staff</h1>
        <form action="staff-list-edit.php" method="post">
            <input type="hidden" name="staffid" value="<?php echo htmlspecialchars($staffid); ?>">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="email">Phone number</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phonenumber; ?>">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-select" name="role">
                    <option Selected value="<?php echo $role; ?>">Choose Role</option>
                    <option value="ADMIN">Admin</option>
                    <option value="MANAGER">Manager</option>
                    <option value="REGULAR STAFF">Regular Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="update-btn">Update</button>
            <a href="staff-list.php" type="button" class="btn btn-danger">Return</a>
        </form>
    </div>
</body>

</html>