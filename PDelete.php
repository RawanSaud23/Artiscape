<?php
// PDelete.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the project ID is provided
    if (isset($_POST['projectId'])) {
        $projectId = $_POST['projectId'];

        // Perform your database deletion operation here based on the project ID
        // Replace the database connection details with your actual credentials
        $connection = mysqli_connect("localhost", "root", "root", "artiscape");
        if (mysqli_connect_error() != null) {
            echo 'An error occurred in the database connection.';
            die(mysqli_connect_error());
        } else {
            // Delete the project from the database
            $sql = "DELETE FROM designportfolioproject WHERE id = '$projectId'";
            $result = mysqli_query($connection, $sql);

            if ($result) {
                // Deletion successful
                echo 'true';
            } else {
                // Deletion failed
                echo 'false';
            }
        }
    } else {
        echo 'Missing project ID.';
    }
} else {
    echo 'Invalid request.';
}
?>