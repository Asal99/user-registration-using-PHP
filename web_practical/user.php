<?php
include 'connection.php';

if (isset($_POST['submit'])) {
    $Full_name = $_POST['name'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO clients (Full_name, Phone, Email, Password) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssss", $Full_name, $Phone, $Email, $Password);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Data inserted successfully
            header("Location: display.php");
        } else {
            // Error in execution
            die(mysqli_stmt_error($stmt));
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing the statement
        die(mysqli_error($conn));
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
</head>
<body>
<div class="container my-5">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" placeholder="Enter your name" name="name" autocomplete="off">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" placeholder="Enter your phone number" name="Phone"
                   autocomplete="off">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" placeholder="Enter your email" name="Email" autocomplete="off">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Enter your password" name="Password"
                   autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>
</body>
</html>
