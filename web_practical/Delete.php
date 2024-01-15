<?php
include 'connection.php';

if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    // Use a prepared statement to delete the record
    $sql = "DELETE FROM `clients` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if($result){
        //echo "Deleted successful";
        header('location:display.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>
