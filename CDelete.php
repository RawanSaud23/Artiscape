<?php
$connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}  
        else{
    if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    
    // Perform the deletion query
    $sql = "DELETE FROM DesignConsultationRequest WHERE id = $deleteId";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
        }
