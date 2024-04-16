<?php
//errors ( as comment before you submition)
error_reporting(E_ALL);

ini_set('log_errors','1');

ini_set('display_errors','1');

    session_start();                       
            //validate user type and get his/her id
            if(isset($_SESSION['id']) || isset($_SESSION['type'])!='designer'){
                $ClientID= $_SESSION['id'];
                $userType= $_SESSION['type'];
            }//else {
//                // display an error message
//                echo "can not find the client ID";
//                exit;
//            } // else session
            
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
            $id2=$_POST['Designer-ID'];  //from the hidden button
            
        // Convert the width and length to a decimal number
        $lengthD = floatval($lengthD);
        $width= floatval($width);
            
        
            $sql600 = "SELECT MAX(id) AS lastID1 FROM designconsultationrequest";
                    $result600 = mysqli_query($connection, $sql600);
                    $lastID1 = 0;

                    if ($result600->num_rows > 0) {
                        while($row600 = mysqli_fetch_assoc($result600)) {

                            $lastID1 = $row600['lastID1']; //no need=> auto increm? 

                        }// while
                    }
                    $newRequestID = $lastID1 + 1;
                    
                    $sql700 = "SELECT id FROM designcategory WHERE category ='$cat'";
                    $result700 = mysqli_query($connection, $sql700);
                
                    while($row700 = mysqli_fetch_assoc($result700)) {
               
                    $designCategoryID3 = $row700['id'];
                    
                    }// while
        
//            $sql2 = "SELECT id FROM roomtype WHERE type='$Rtype'";
//            $result2 = mysqli_query($connection, $sql2);
//            while($row2 = mysqli_fetch_assoc($result2)) {
//               
//                    $Rid1 = $row2['id'];
//                    
//                    } while
                    
                    $sql800 = "SELECT * FROM roomtype WHERE type ='$Rtype'";
                    $result800 = mysqli_query($connection, $sql800);
                
                    while($row800 = mysqli_fetch_assoc($result800)) {
               
                    $roomTypeID = $row800['id'];
                    
                    }// while
                    
            //$Rid=$row2['id'];
                
//            $sql3 = "SELECT id FROM DesignCategory WHERE category='$cat'";
//            $result3 = $connection->query($sql3);
//            $row3 = $result3->fetch_assoc();
//            $Catid=$row3['id'];
            
            $currentDate = date('Y-m-d');
                    
            $sql4 = "INSERT INTO designconsultationrequest (clientID, designerID, "
             . "roomTypeID, designCategoryID, roomWidth, roomLength, colorPreferences, "
             . "date, statusID) VALUES ('$ClientID', '$id2',"
             . "'$roomTypeID', '$designCategoryID3', '$width', '$lengthD', "
             . "'$color', '$currentDate', '1')";
                
//            $sql4="INSERT INTO designconsultationrequest ( clientID, designerID, roomTypeID,designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES ( $newRequestID, $ClientID, $designerId, $Rid,
//            $Catid, $width, $lengthD, $color, $currentDate, '1')";

            $result4 = mysqli_query($connection, $sql4);
            if ($result4) {
                echo "<script> alert('Successfully added'); </script>";
                // Redirect to homepage after successful insertion
                header("Location: ClientHomepage.php");
                exit();
            } else {
                echo 'Error: ' . mysqli_error($connection);
            }
            }//POST///