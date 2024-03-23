<?php
        $connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}
            
        else{
        if (isset($_GET['project_id'])) {
        $projectID = $_GET['project_id'];
        $query = "DELETE FROM DesignPortoflioProject WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $projectID);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Deletion successful, redirect to designer's homepage
        header("Location: DesignerHomepage.php");
        exit;
    }
}
        }
?>
