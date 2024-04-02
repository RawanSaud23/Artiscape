<?php
$connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}  
        else{
    if (isset($_GET['add'])) {
    $addreq = $_GET['add'];

    $sql = "Update FROM designconsultationrequest SET statusID='2' WHERE id = $addreq";///////////
   if (mysqli_query($connection, $sql)) {
   echo '<script>alert ("The consulation is requested.")</script>';
   header("Location: DesignerHomepage.php");
   } else {
   echo '<script>alert("Error while declining the request")</script>';
   }
}
        }