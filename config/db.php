<?php
	$db_server = "localhost";
	$db_user = "root";
	$db_pass = "";
	$conn = mysqli_connect($db_server, $db_user, $db_pass);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlFile = __DIR__ . '/init.sql';
    $sql = file_get_contents($sqlFile);

    if ($conn->multi_query($sql)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
        echo "Database initialized successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
?>