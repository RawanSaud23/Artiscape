<?php

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
            }else{
                $designerId = $_GET['DesignerID'];
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {   
            $Rtype=$_POST['RoomType'];
            $width = $_FILES['widthD'];
            $lengthD=$_POST['lengthD'];
            $cat=$_POST['category'];
            $color=$_POST['color'];
            
            
            $sql2 = "SELECT id FROM RoomType WHERE type='$Rtype'";
            $result2 = $connection->query($sql2);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $Rid=$row2['id'];
                
            $sql3 = "SELECT id FROM DesignCategory WHERE category='$cat'";
            $result3 = $connection->query($sql3);
            if ($result3->num_rows > 0) {
                $row3 = $result3->fetch_assoc();
                $Catid=$row3['id'];
                
                //add new reqest design consultation to the database
                $sql4="INSERT INTO designconsultationrequest ( clientID, designerID, roomTypeID,
                designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES (( $Cid, $designerId, $Rid,
                $Catid, $width, $lengthD, $color, date(Y-m-d), '1'))"; //////////////
                $result4=mysqli_query($connection, $sql4);
                if ($result4) {
                // Redirect to homepage after successful insertion
                header("Location: ClientHomepage.php?id=" .$_SESSION['id']);
                exit();
            }}
            }
            }
            
             
        $consultation = $_POST['Consultation'];
        $img = $_POST['ConsultationImage'];
        $sql3 = "INSERT INTO designconsultation (requestID ,consultation ,consultationImgFileName) VALUES ('$id', '$consultation', '$img')";
        $result3 = mysqli_query($conn, $sql3);

        if ($result3) {
            header("Location: DesignerHomePage.php?id=" . $_SESSION['id']);
            exit();
        }
    