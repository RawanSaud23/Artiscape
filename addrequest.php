<?php

    session_start();                       
            //validate user type and get his/her id
            if(isset($_SESSION['id']) || isset($_SESSION['type'])!='designer'){
                $ClientID= $_SESSION['id'];
                $userType= $_SESSION['type'];
            }
            
            if(!isset($_SESSION['id'])){ //when the user is designer
              header("Location: index.php");
                exit();
            } 
            
            $connection= mysqli_connect('localhost','root', 'root', 'artiscape');
            
            //error handling
            $error= mysqli_connect_error();
            if ($error!=null){                                                          
                exit('database cannot found');                                      
            }
            
            //get user Consultation request
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $Rtype=$_POST['RoomType'];
            $width = $_POST['widthD'];
            $lengthD=$_POST['lengthD'];
            $cat=$_POST['category'];
            $color=$_POST['color'];
            
            
        // Convert the width and length to a decimal number
        $lengthD = floatval($lengthD);
        $width= floatval($width);
            
            $sql2 = "SELECT id FROM RoomType WHERE type='$Rtype'";
            $result2 = $connection->query($sql2);
            $row2 = $result2->fetch_assoc();
            $Rid=$row2['id'];
                
            $sql3 = "SELECT id FROM DesignCategory WHERE category='$cat'";
            $result3 = $connection->query($sql3);
            $row3 = $result3->fetch_assoc();
            $Catid=$row3['id'];
                
            $sql4="INSERT INTO designconsultationrequest ( clientID, designerID, roomTypeID,
            designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES (( $ClientID, $designerId, $Rid,
            $Catid, $width, $lengthD, $color, 'date(Y-m-d)', '1'))";

            if (mysqli_query($connection, $sql4)) {
            // Redirect to homepage after successful insertion
            header("Location: ClientHomepage.php");
            exit();
            }
            }//POST///









$connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}  
        else{
    if (isset($_GET['add'])) {
    $addreq = $_GET['add'];

    $sql="INSERT INTO designconsultationrequest ( clientID, designerID, roomTypeID,
            designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES (( $ClientID, $designerId, $Rid,
            $Catid, $width, $lengthD, $color, 'date(Y-m-d)', '1')) WHERE id= $addreq";
   if (mysqli_query($connection, $sql)) {
   echo '<script>alert ("The consulation is requested.")</script>';
   header("Location: DesignerHomepage.php");
   } else {
   echo '<script>alert("Error while declining the request")</script>';
   }
}
        }