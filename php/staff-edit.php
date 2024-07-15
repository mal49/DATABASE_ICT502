<?php 
    include("connect.php");


    $errorMessage = "";
    $successMessage = "";

    $id = $isbn = $book_title = $genre = $author = $publisher = $price = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "" ;

        if(empty($id))
        {
            header("location: inventory.php");
            exit;
        }

        $sql = "SELECT * FROM book_reps WHERE ISBN=:id";
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
    }
    elseif($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $isbn = $_POST['isbn'];
        $book_title = isset($_POST['book_name']) ? $_POST['book_name'] : "";
        $genre = isset($_POST['genre']) ? $_POST['genre'] : "";
        $author = isset($_POST['author']) ? $_POST['author'] : "";
        $publisher = isset($_POST['publisher']) ? $_POST['publisher'] : "";
        $price = isset($_POST['price']) ? $_POST['price'] : "";

        $sql = "UPDATE book_reps SET ISBN=:isbn, 
                                     BOOK_NAME=:book_name,
                                     GENRE =:genre,
                                     AUTHOR =: author,
                                     PUBLISHER=:publisher,
                                     PRICE=:price
                                     WHERE ISBN=:id";

        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':isbn', $isbn);
        oci_bind_by_name($stmt, ':book_name', $book_title);
        oci_bind_by_name($stmt, ':genre', $genre);
        oci_bind_by_name($stmt, ':author', $author);
        oci_bind_by_name($stmt, ':publisher', $publisher);
        oci_bind_by_name($stmt, ':price', $price);
        oci_bind_by_name($stmt, ':id', $id);

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
        <form action="inventory.php" method="post">
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn"
                    value="<?php echo htmlspecialchars($isbn); ?>">
            </div>
            <div class="form-group">
                <label for="book_name">Book Name</label>
                <input type="text" class="form-control" id="book_title" name="book_name"
                    value="<?php echo htmlspecialchars($book_title); ?>">
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre"
                    value="<?php echo htmlspecialchars($genre);  ?>">
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author"
                    value="<?php echo htmlspecialchars($author); ?>">
            </div>
            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control" id="publisher" name="publisher"
                    value="<?php echo htmlspecialchars($publisher); ?>">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price"
                    value="<?php echo htmlspecialchars($price); ?>">
            </div>
            <div class="form-group">
                <label for="avail">Availability</label>
                <select class="form-select" name="select-avail">
                    <option Selected value="PS">Choose Availability</option>
                    <option value="IN STOCK">In Stock</option>
                    <option value="OUT-OF-STOCK">Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="update-btn">Update</button>
            <a href="inventory.php" type="button" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</body>

</html>