<?php
// DeclineRequest.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request ID is provided
    if (isset($_POST['requestId'])) {
        $requestId = $_POST['requestId'];

        // Perform your database update operation here based on the request ID
        // Replace the database connection details with your actual credentials
        $connection = mysqli_connect("localhost", "root", "root", "artiscape");
        if (mysqli_connect_error() != null) {
            echo 'An error occurred in the database connection.';
            die(mysqli_connect_error());
        } else {
            // Update the request status in the database
    $sql = "Update designconsultationrequest SET statusID='2' WHERE id = $requestId";
            $result = mysqli_query($connection, $sql);

            if ($result) {
                // Update successful
                echo 'true';
            } else {
                // Update failed
                echo 'false';
            }
        }
    } else {
        echo 'Missing request ID.';
    }
} else {
    echo 'Invalid request.';
}
?>