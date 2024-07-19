<?php 
    include("connect.php");


    $errorMessage = "";
    $successMessage = "";

    $isbn = $book_title = $genre = $author = $publisher = $price = $availability = "";

    /*if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "" ;

        if(empty($id))
        {
            header("location: inventory.php");
            exit;
        }

        $sql = "SELECT * FROM book_reps WHERE ISBN=:id AND PRICE=:price";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $row = oci_fetch_assoc($stmt);

        if(!$row)
        {
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
    }*/
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $isbn = $_POST['isbn'];
        $price = $_POST['price'];
        $book_title = $_POST['book-title'];
        $availability = isset($_POST['availability']) ? $_POST['availability'] : "";
        if(isset($_POST['update-btn']))
        {

                $sql = "UPDATE book_reps SET PRICE=:price,
                                             STATUS=:status
                                             WHERE ISBN=:id";
                                        
            $stmt = oci_parse($conn, $sql);

            oci_bind_by_name($stmt, ':price', $price);
            oci_bind_by_name($stmt, ':status', $availability);
            oci_bind_by_name($stmt, ':id', $isbn);

            $result = oci_execute($stmt);

            if ($result) {
                $successMessage = "Record updated successfully!";
                header("location: inventory.php");
                exit;
            } else {
                $errorMessage = "Error updating record!";
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
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
        <h1 class="display-4 text-center">Update Book</h1>
        <form action="staff-edit.php" method="post">
            <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
            <div class="form-group">
                <label for="book-title">Book Title</label>
                <input class="form-control" type="text" value="<?php echo $book_title; ?>"
                    aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
            </div>
            <div class="form-group">
                <label for="role">Status</label>
                <select class="form-select" name="availability">
                    <option Selected value="<?php echo $availability; ?>">Choose status</option>
                    <option value="IN STOCK">IN STOCK</option>
                    <option value="OUT OF STOCK">OUT OF STOCK</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="update-btn">Update</button>
            <a href="inventory.php" type="button" class="btn btn-danger">Return</a>
        </form>
    </div>
</body>

</html>