<?php
include 'connection.php';

// Check if 'updateid' is set in the URL
if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];

    // Use a prepared statement to select user data
    $sqlSelect = "SELECT * FROM `clients` WHERE id = ?";
    $stmtSelect = mysqli_prepare($conn, $sqlSelect);
    mysqli_stmt_bind_param($stmtSelect, "i", $id);
    mysqli_stmt_execute($stmtSelect);
    $resultSelect = mysqli_stmt_get_result($stmtSelect);

    // Check if any results are returned
    if ($row = mysqli_fetch_assoc($resultSelect)) {
        $Full_name = $row['Full_name'];
        $Phone = $row['Phone'];
        $Email = $row['Email'];
        $Password = $row['Password'];
    } else {
        // Handle the case where no record is found
        die("No record found for the given ID");
    }

    mysqli_stmt_close($stmtSelect);
} else {
    // Handle the case where 'updateid' is not set
    die("No 'updateid' parameter in the URL");
}

if (isset($_POST['submit'])) {
    // Update user data using a prepared statement
    $Full_name = $_POST['name'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $sqlUpdate = "UPDATE `clients` SET Full_name=?, Phone=?, Email=?, Password=? WHERE id=?";
    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "ssssi", $Full_name, $Phone, $Email, $Password, $id);
    
    if (mysqli_stmt_execute($stmtUpdate)) {
        echo "Updated successfully";
        //header("Location:display.php");
    } else {
        die("Error updating record: " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmtUpdate);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
</head>
<body>
<div class="container my-5">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" placeholder="Enter your name" name="name" autocomplete="off"
                   value="<?php echo $Full_name; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" placeholder="Enter your phone number" name="Phone"
                   autocomplete="off" value="<?php echo $Phone; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" placeholder="Enter your email" name="Email" autocomplete="off"
                   value="<?php echo $Email; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Enter your password" name="Password"
                   autocomplete="off" value="<?php echo $Password; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Update</button>
    </form>
</div>
</body>
</html>
