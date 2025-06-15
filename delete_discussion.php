<?php
    session_start();
    include("config/db.php");

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $disc_id = (int) $_GET['id'];  // type cast to ensure it's an integer
        $sql = "DELETE FROM discussions WHERE id = $disc_id";

        if (mysqli_query($conn, $sql)) {
            header("Location: your_discussions.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid discussion ID.";
    }
?>