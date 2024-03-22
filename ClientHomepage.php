<?php
//include 

//errors ( as comment before you submition)
error_reporting(E_ALL);

ini_set('log_errors','1');

ini_set('display_errors','1');
?>
<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="utf-8">
        <title>Client homepage</title>
        <link rel="stylesheet" href="ArtiScape.css">
        <style>                    
            table{
                border-collapse: collapse; /*No spaces between the cells*/
                width: 100%;  /*as same as the page width*/ 
            }
            th, td{
                border: 1px solid black;
                text-align: center;
            }
            td{
                height: 70px;
            }
            td a img{
                width: 30%;
            }
            th:not(#noBorder){ /*No background color for the last th*/
                background-color: #C3B1E1;
            }
            caption{
                float: left;
                font-size:x-large;
            }
            #ClientInfo{ /* name and email at top of the page */
                background-color: #E6E6FA;
                padding: 5px;
                margin: auto;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            #Category{ /*Specialty filter */
                float: right;
            }
            /* Form submit button (Filter) */
          button {
            background-color: #9678b6;
            color: white;
            border-radius: 4px;
          }
        
          /* Form submit button (Filter) hover effect */
          button:hover {
            background-color: #800080;
          }
        </style>
        </style>
      </head>

      <body>
    
        <header>
            <nav>
                <a href="ClientHomepage.html"><img id="logo" src="images/Logo.png" alt="Logo"></a>
                <a href="index.html" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a> 
            </nav>  
          </header>
       
       
            <?php
           
            session_start();
            
            /*
            //validate user type and get his/her id
            if(isset($_SESSION['id']) && isset($_SESSION['type'])){
                $ClientID= $_SESSION['id'];
                $userType= $_SESSION['type'];
            }
            
            if(!isset($_SESSION['id']) == 0){ //when the user is designer
                header("Location: index.php"); //Designer Homepage insted of OR Log in??
                exit();
            } 
          */
            //DB connection from the include file
            $connection= mysqli_connect('localhost','root', 'root', 'artiscape');
            
            //error handling
            $error= mysqli_connect_error();
            if ($error!=null){                                                          
                exit('database cannot found');                                      
            }
            
            //request client info (for the welcoming card): 
            //$sql="SELECT * FROM client WHERE id='$ClientID'";
            $sql="SELECT * FROM client WHERE id='1'";
            $result= mysqli_query($connection, $sql);
            
            /*if($row= mysqli_fetch_assoc($result)){
            $client1Name= $row['firstName'];
            $clintLName= $row['lastName'];
            $clientEmail= $row['emailAddress'];    
            }*/
            
            $client= mysqli_fetch_assoc($result);
            $client1Name= $client['firstName'];           
            $clintLName= $client['lastName'];
            $clientEmail= $client['emailAddress'];
            ?>
          
          <main>
                <!-- welcoming card -->
            <h2>Welcome <?php echo $client1Name; ?>!</h2>

            <div id="ClientInfo">
                <p>Name: <?php echo $client1Name .' ' .$clintLName; ?></p>
                <p>email: <?php echo $clientEmail; ?> </p>
            </div>
            <br>
            
            <form method="post" action="index.php" id="Category" name="category"> <!-- action="ClientHomepage.php" -->
                    <label>Select Category: </label>
                    <select name="category">
                        <?php
                        //form for filtering designers by category:
                        $sql_category="SELECT category FROM DesignCategory";
                        $result_category= mysqli_query($connection, $sql_category);
                        
                        while ($row = mysqli_fetch_assoc($result_category)){
                            echo '<option>' .$row['category'] .'</option>';
                        }
                        ?>
                    </select>
                    <button type="submit" value="Filter">Filter</button>
                </form>
            
            <!-- Interior Designers table -->
            <table>
                    <caption>Interior Designers</caption>
                    <tr>
                        <th>Designer</th>
                        <th>Specialty</th>
                        <th style="border: none;" id="noBorder"></th> <!--inline style for no border in last th cell-->
                    </tr>
                    
                    <?php
                    //Case 1: no Category selected (default Get)
                    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
                        $sql_get="SELECT * FROM designer";//no Speciality slected so,no condition
                        $result_get= mysqli_query($connection, $sql_get);
                        
                        while ($row = mysqli_fetch_assoc($result_get)){
                            echo '<tr><td> <a href="DesignPortoflioProject.php?id=' .$row['id'] .'"> <br>'; //logoImgFileName
                            echo $row['brandName'] .'</a></td>';
                            
                            //Specialty
                            $sql_get2="SELECT * FROM designspeciality WHERE designerID='" .$row['id'] ."'";
                            $result_get2= mysqli_query($connection, $sql_get2);
                            while($row2= mysqli_fetch_assoc($result_get2)){
                                $sql_get3="SELECT category FROM designcategory WHERE id='" .$row2['designCategoryID'] ."'";
                                $result_get3= mysqli_query($connection, $sql_get3);
                                $row3= mysqli_fetch_assoc($result_get3);
                                echo "<td>" .$row3['category'] ."</td>";//try if there is mant cate for brand
                            }    
                            
                            //The request design consultation link is a code-generated link to the request design 
                            //consultation page for the corresponding designer:
                            echo "<td> <a href= DesignConsultationRequest.php?DesignerID=" .$row['id'] ."> Request Design Consultation </td>";////Request Design Consultation
                            echo '</tr>';
                        }


                    //2nd Case when user select Category                           
                    }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $CatID=$_POST['category'];
                        $sql_post= "SELECT * FROM designspeciality WHERE designCategoryID='$CatID'";
                        $result_post= mysqli_query($connection, $sql_post);
                        
                        while ($row = mysqli_fetch_assoc($result_post)){
                            //img + brand name
                            $sql_post2="SELECT * FROM Designer WHERE id='" .$row['designerID'] ."'";
                            $result_post2= mysqli_query($connection, $sql_post2);
                            $row2= mysqli_fetch_assoc($result_post2);
                            echo '<tr><td> <a href="DesignPortoflioProject.php?id=' .$row2['id'] .'"> <br>';
                            echo $row2['brandName'] .'</a></td>';//there is somthing wrong
                            
                            //Specialty
                            $sql_post3="SELECT category FROM designcategory WHERE id='" .$row['designCategoryID'] ."'";
                            $result_post3= mysqli_query($connection, $sql_post3);
                            while ($row3= mysqli_fetch_assoc($result_post3)){
                                 echo "<td>"  ."<br>" .$row3['category'] ."</td>"; 
                            } 
                            
                            //The request design consultation link is a code-generated link to the request design 
                            //consultation page for the corresponding designer:
                            echo "<td> <a href= DesignConsultationRequest.php?DesignerID=" .$row['id'] ."> Request Design Consultation </td>";////Request Design Consultation
                            echo '</tr>';
                        }
                        
                    }
                    ?>

                </table>            
            
           
            <?php
            //Previous Design Consultation Requests (TABLE):
            if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<caption>Consultation Design Requests</caption>';
            echo '<tr>
            <th>Designer</th>
            <th>Room Type</th>
            <th>Room Dimensions</th>
            <th>Design Category</th>
            <th>Color Preferences</th>
            <th>Date of Request</th>
            <th>Status</th>
            <th>Consultation</th>
          </tr>';
    
            $sql_7col=""; //='$clientID'
            $result_7col = mysqli_query($connection, $sql_7col);
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td><img src="' . $row['logoImgFileName'] . '" alt="Designer Logo">' . $row['brandName'] . '</td>';
                echo '<td>' . $row['type'] . '</td>';
                echo '<td>' . $row['roomWidth'] . 'm x ' . $row['roomLength'] . 'm</td>';
                echo '<td>' . $row['category'] . '</td>';
                echo '<td>' . $row['colorPreferences'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td>';

                // If a consultation vided for a request, then the consultation and its image are shown in the corresponding cell.
                if ($row['consultation']) {
                    echo $row['consultation'];
                    echo '<br>';
                    echo '<img src="' . $row['consultationImgFileName'] . '" alt="Consultation Image">';
                }
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
            } else {
            echo 'No consultation design requests found.';
            }

            
            
            ?>
            
          </main>
      </body>
          
            </html>