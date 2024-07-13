<?php 
    include("connect.php");

    $isbn = $_POST['ISBN'] ?? '';
    $book_name = $_POST['BOOK_NAME'] ?? '';
    $genre = $_POST['GENRE'] ?? '';
    $author = $_POST['AUTHOR'] ?? '';
    $publisher = $_POST['PUBLISHER'] ?? '';
    $price = $_POST['PRICE'] ?? '';
    $status = $_POST['STATUS'] ?? '';

    $sql = "UPDATE book_reps SET PRICE = :price, STATUS = :status WHERE ISBN = :isbn";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ':isbn',  $isbn);
    oci_bind_by_name($stid, ':price',  $price);
    oci_bind_by_name($stid, ':status',  $status);

    $result = oci_execute($stid);

    if ($result) {
        echo "User updated successfully.";
    } else {
        $e = oci_error($stid);
        echo "Error: " . $e['message'];
    }
    
    oci_free_statement($stid);
    oci_close($conn);
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: monospace, sans-serif;
         }
    </style>
<body>
    <div class="container my-5">
        <h1>EDIT/UPDATE</h1>
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ISBN</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="isbn" value="<?php echo $isbn; ?>"> 
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">BOOK TITLE</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bk-title" value="<?php echo $book_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">GENRE</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="genre" value="<?php echo $genre; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">AUTHOR</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="author" value="<?php echo $author; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PUBLISHER</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="publisher" value="<?php echo $publisher; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PRICE</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">STATUS</label>
                <select class="form-select" aria-label="Default select example" name="select-status" style="width: auto; margin-left: 10px;">
                    <option selected>Select Status</option>
                    <option value="AVAILABLE" <?php echo ($status == 'AVAILABLE') ? 'selected' : '' ?> >Available</option>
                    <option value="OUT-OF-STOCK" <?php echo ($status == 'OUT-OF-STOCK') ? 'selected' : '' ?> >out of stock</option> 
                 </select>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="inventory.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>