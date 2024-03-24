<?php
        $connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}
            
        else{
        if (isset($_GET['project_id'])) {
        $projectID = $_GET['project_id'];
        $sql = "DELETE FROM designportfolioproject WHERE id = $projectID";
        if (mysqli_query($connection, $sql)) {
        echo '<script>alert ("Project deleted succesfully.")</script>';
        header("Location: DesignerHomepage.php");
        } else {
        echo '<script>alert("Error while deleting the project")</script>';
   }
    }
}
        
?>
