<?php
    include("connect.php");

    $sql = "SELECT * FROM staff";
    $stid = oci_parse($conn, $sql);

    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $execute_success = oci_execute($stid);

    if (!$execute_success) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $rows = array();
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $rows[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: monospace, sans-serif;
        font-size: 15px;
    }
    </style>
</head>

<body style="margin: 50px;">
    <div class="container">
        <h1>Staff List</h1>
        <a href="siso-staff-register.php" type="button" class="btn btn-warning">Add staff</a>
        <a href="../html/staff-homepage.html" type="button" class="btn btn-dark">To Homepage</a>
        <table class="table">
            <thead>
                <tr>
                    <th>STAFF ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE NUMBER</th>
                    <th>ROLE</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo isset($row['STAFFID']) ? htmlentities($row['STAFFID']) : ''; ?></td>
                    <td><?php echo isset($row['NAME']) ? htmlentities($row['NAME']) : ''; ?></td>
                    <td><?php echo isset($row['EMAIL']) ? htmlentities($row['EMAIL']) : ''; ?></td>
                    <td><?php echo isset($row['PHONE_NUM']) ? htmlentities($row['PHONE_NUM']) : ''; ?></td>
                    <td><?php echo isset($row['ROLE']) ? htmlentities($row['ROLE']) : ''; ?></td>
                    <td>
                        <form method="post" action="staff-list-edit.php">
                            <input type="hidden" name="staffid"
                                value="<?php echo isset($row['STAFFID']) ? htmlentities($row['STAFFID']) : ''; ?>">
                            <input type="hidden" name="name"
                                value="<?php echo isset($row['NAME']) ? htmlentities($row['NAME']) : ''; ?>">
                            <input type="hidden" name="email"
                                value="<?php echo isset($row['EMAIL']) ? htmlentities($row['EMAIL']) : ''; ?>">
                            <input type="hidden" name="phonenumber"
                                value="<?php echo isset($row['PHONE_NUM']) ? htmlentities($row['PHONE_NUM']) : ''; ?>">
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                        <form method="post" action="delete-staff.php">
                            <input type="hidden" name="staffid"
                                value="<?php echo isset($row['STAFFID']) ? htmlentities($row['STAFFID']) : ''; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8">No staff found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
    oci_free_statement($stid);
    oci_close($conn);
?>