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

        $sql = "SELECT * FROM book_reps WHERE ISBN:=id";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $row = oci_fetch_assoc($stmt);

        if(!$row)
        {
            header("location: inventory.php");
            exit;
        }

        $isbn = isset($row['ISBN']) ? $row['ISBN'] : "";
        $book_title = isset($row['BOK_NAME']) ? $row['BOOK_NAME'] : "";
        $genre = isset($row['GENRE']) ? $row['GENRE'] : "";
        $author = isset($row['AUTHOR']) ? $row['AUTHOR'] : "";
        $publisher = isset($row['PUBLISHER']) ? $row['PUBLISHER'] : "";
        $price = isset($row['PRICE']) ? $row['PRICE'] : "";
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
                                     BOOK_NAME=:title,
                                     GENRE =:genre,
                                     AUTHOR =: author,
                                     PUBLISHER=:publisher,
                                     PRICE=:price
                                     WHERE ISBN=:id";

        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':isbn', $isbn);
        oci_bind_by_name($stmt, ':title', $book_title);
        oci_bind_by_name($stmt, ':genre_id', $genre);
        oci_bind_by_name($stmt, ':author_id', $author);
        oci_bind_by_name($stmt, ':publisher_id', $publisher);
        oci_bind_by_name($stmt, ':price', $price);
        oci_bind_by_name($stmt, ':id', $id);

        $result = oci_execute($stmt);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
</head>
<style>
    *{
        margin: 0;
        padding: 5px;
        box-sizing: border-box;
        font-family: monospace, sans-serif;
        font-size: 15px;
    }

    .container button{
        margin-top: 10px;
        margin-left: 5px;
    }

    .container form{
        width: 500px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        margin-left: 30%;
    }
</style>
<body>
    <div class="container">
    <h1 class="display-4 text-center">Update Book</h1>
        <form action="add-book.php" method="post">
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="name" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>"> 
            </div>
            <div class="form-group">
                <label for="isbn">Book Name</label>
                <input type="text" class="form-control" id="bk-title" name="bk-title" value="<?php $row['bk-title']  ?>>
            </div>
            <div class="form-group">
                <label for="isbn">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php $row['genre']  ?>>
            </div>
            <div class="form-group">
                <label for="isbn">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php $row['author']  ?>>
            </div>
            <div class="form-group">
                <label for="isbn">Publisher</label> 
                <input type="text" class="form-control" id="publisher" name="publisher" value="<?php $row['publisher']  ?>>
            </div>
            <div class="form-group">
                <label for="isbn">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php $row['price']  ?>>
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
        </form>
    </div>
</body>
</html>