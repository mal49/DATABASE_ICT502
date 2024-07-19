<?php
include("connect.php");

$errorMessage = "";
$successMessage = "";

$id = $isbn = $book_title = $genre = $author = $publisher = $price = $availability = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : "";

    if (empty($id)) {
        header("location: inventory.php");
        exit;
    }

    $sql = "SELECT * FROM book_reps WHERE ISBN=:id";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":id", $id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if (!$row) {
        header("location: inventory.php");
        exit;
    }

    $isbn = $row['ISBN'];
    $book_title = $row['BOOK_NAME'];
    $genre = $row['GENRE'];
    $author = $row['AUTHOR'];
    $publisher = $row['PUBLISHER'];
    $price = $row['PRICE'];
    $availability = $row['STATUS'];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['isbn'];
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0; // Validate price as a float
    $availability = isset($_POST['select-avail']) ? $_POST['select-avail'] : "";

    // Basic input validation for price
    if ($price < 0) {
        $errorMessage = "Price must be a non-negative number.";
    } else {
        $sql = "UPDATE book_reps SET PRICE=:price, STATUS=:status WHERE ISBN=:id";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':price', $price);
        oci_bind_by_name($stmt, ':status', $availability);
        oci_bind_by_name($stmt, ':id', $id);

        $result = oci_execute($stmt);

        if ($result) {
            $successMessage = "Record updated successfully!";
            header("location: inventory.php");
            exit;
        } else {
            $errorMessage = "Error updating record: " . oci_error($stmt); // Get detailed error message
        }
    }
}
?>
