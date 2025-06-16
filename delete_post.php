<?php
    session_start();
    include("config/db.php");
    $isloggedin = isset($_SESSION['user_id']);
    if (!$isloggedin) {
        echo "<script>alert('You have to log in first to edit a discussion" . $isloggedin . "');window.location.href='login.php';</script>";
        exit();
    }
    else {
        $post_id = $_GET['id'];
        $sql = "SELECT * FROM posts WHERE id = $post_id";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $disc_id = htmlspecialchars($row['discussion_id']);
        } else {
            echo "<script>alert('Post not found');window.location.href='your_discussions.php';</script>";
            exit();
        }
        
        $sql = "DELETE FROM posts WHERE id = $post_id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Post deleted successfully');window.location.href='single.php?id={$disc_id}';</script>";
            $sql2 = "UPDATE discussions SET post_count = post_count - 1 WHERE id = $disc_id";
            mysqli_query($conn, $sql2);
        } else {
            echo "<script>alert('Error deleting post: " . mysqli_error($conn) . "');window.location.href='single.php?id={$disc_id}';</script>";
        }
    }
?>