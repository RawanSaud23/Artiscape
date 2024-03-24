<?php
$connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}  
        else{
    if (isset($_GET['updatedid'])) {
    $updatedid = $_GET['updatedid'];

    $sql = "Update FROM designconsultationrequest SET statusID='2' WHERE id = $updatedid";
   if (mysqli_query($connection, $sql)) {
   echo '<script>alert ("The consulation is declined.")</script>';
   header("Location: DesignerHomepage.php");
   } else {
   echo '<script>alert("Error while declining the request")</script>';
   }
}
        }
