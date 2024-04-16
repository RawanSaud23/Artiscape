<?php
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
            td a img, td img{
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
                <a href="ClientHomepage.php"><img id="logo" src="images/Logo.png" alt="Logo"></a>
                <a href="signout.php" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a> 
            </nav>  
          </header>
       
       
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
         
            //DB connection from the include file
            $connection= mysqli_connect('localhost','root', 'root', 'artiscape');
            
            //error handling
            $error= mysqli_connect_error();
            if ($error!=null){                                                          
                exit('database cannot found');                                      
            }
            
            //request client info (for the welcoming card): 
            $sql="SELECT * FROM client WHERE id='$ClientID'";
            $result= mysqli_query($connection, $sql);
            
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
                <p>email: <?php echo $clientEmail; ?> </p> <!-- MISSING style -->
            </div>
            <br>
            
            <form method="post" action="ClientHomepage.php" id="Category">
                    <label>Select Category: </label>
                    <select name="category">
                        <?php
                        //form for filtering designers by category:
                        $sql_category="SELECT * FROM designcategory";
                        $result_category= mysqli_query($connection, $sql_category);
                        //retrive all the categories from DB
                        while ($row = mysqli_fetch_assoc($result_category)){
                            echo "<option value='" .$row['id'] ."'>" .$row['category'] ."</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" value="Filter" id="filt">Filter</button>
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
                            echo '<tr><td> <a href="DesignPortoflioProject.php?id=' . $row['id'] . '"> <img src="images/' . $row['logoImgFileName'] . '" alt="' . $row['brandName'] . '"> <br>' . $row['brandName'] . '</a></td>';
                            
                            //Specialty
                            $sql_get2="SELECT * FROM designspeciality WHERE designerID='" .$row['id'] ."'";
                            $result_get2= mysqli_query($connection, $sql_get2);
                            
                            $CAT = "";
                            echo "<td>";
                            $firstCategory = true;
                            while ($row2 = mysqli_fetch_assoc($result_get2)) {
                                $sql_get3 = "SELECT category FROM designcategory WHERE id='" . $row2['designCategoryID'] . "'";
                                $result_get3 = mysqli_query($connection, $sql_get3);
                                $row3 = mysqli_fetch_assoc($result_get3);

                                if ($firstCategory) {
                                    $CAT .= $row3['category'];
                                    $firstCategory = false;
                                } else {
                                    $CAT .= ', ' . $row3['category'];
                                }
                            }
                            echo $CAT;
                            echo '</td>';
                            
                            //The request design consultation link is a code-generated link to the request design 
                            //consultation page for the corresponding designer:
                            echo "<td> <a href= RequestDesignConsultation.php?DesignerID=" .$row['id'] ."> Request Design Consultation </td>";////Request Design Consultation
                            echo '</tr>';
                        }


                    //2nd Case when user select Category                           
                    }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $CatID = $_POST['category'];
                        
                        $sql_post = "SELECT * FROM designspeciality WHERE designCategoryID='$CatID'";
                        $result_post= mysqli_query($connection, $sql_post);
                        while ($row = mysqli_fetch_assoc($result_post)){
                            //img + brand name
                            $sql_post2="SELECT * FROM designer WHERE id='" .$row['designerID'] ."'";
                            $result_post2= mysqli_query($connection, $sql_post2);
                            while($row2= mysqli_fetch_assoc($result_post2)){
                            //<img src="images/' . $row2['logoImgFileName'] . '" alt="' . $row2['brandName'] . '"> <br>' . $row2['brandName'] . '</td>'
                            echo '<tr><td> <a href="DesignPortoflioProject.php?id=' . $row2['id'] . '"> <img src="images/' . $row2['logoImgFileName'] . '" alt="' . $row2['brandName'] . '"> <br>' . $row2['brandName'] . '</a></td>';                            
                            //Specialty
                            $sql_post3 = "SELECT * FROM designspeciality WHERE designerID='" .$row['designerID']."'";
                            $result_post3= mysqli_query($connection, $sql_post3);
                            $CAT = "";
                            echo "<td>";
                            $firstCategory = true;
                            while ($row3= mysqli_fetch_assoc($result_post3)) {
                                $sql4= "SELECT category FROM designcategory WHERE id='". $row3['designCategoryID']."'";
                                $result4= mysqli_query($connection, $sql4);
                                if($row4= mysqli_fetch_assoc($result4)){
                                    if ($firstCategory) {
                                    $CAT .= $row4['category'];
                                    $firstCategory = false;
                                } else {
                                    $CAT .= ', ' . $row4['category'];
                                }
                                }
                            }
                            echo $CAT;
                            echo '</td>';
                            //The request design consultation link is a code-generated link to the request design 
                            //consultation page for the corresponding designer:
                            echo "<td> <a href= RequestDesignConsultation.php?DesignerID=" .$row['designerID'] ."> Request Design Consultation</a> </td>";////Request Design Consultation
                            echo '</tr>';
                        }
                        }
                    }
                    ?>

                </table>            
                
        <!-- Previous Design Consultation Requests for specific client ID (TABLE): -->
        <table>
                <caption style="margin-top: 1em;">Previous Design Consultation Requests</caption>
                <tr>
                    <th>Designer</th>
                    <th>Room</th>
                    <th>Dimensions</th>
                    <th>Design Category</th>
                    <th>Color Preferences</th>
                    <th>Requests Date</th>
                    <th>Design Consultation</th>
                </tr>
          
            <?php
            $sql_7col="SELECT * FROM designconsultationrequest WHERE clientID='$ClientID'" ;
            $result_7col = mysqli_query($connection, $sql_7col);
            
            while ($row7 = mysqli_fetch_assoc($result_7col)) {
                //img + brand name
                $sql1="SELECT * FROM Designer WHERE id='" .$row7['designerID'] ."'";
                $result1= mysqli_query($connection, $sql1);
                $row1= mysqli_fetch_assoc($result1);
                echo '<tr> <td> <img src="images/' . $row1['logoImgFileName'] . '" alt="' . $row1['brandName'] . '"> <br>' . $row1['brandName'] . '</td>';
            
                //Room
                $sql2="SELECT type FROM roomtype WHERE id='" .$row7['roomTypeID'] ."'";
                $result2= mysqli_query($connection, $sql2);
                $row2= mysqli_fetch_assoc($result2);
                echo '<td>' .$row2['type'] .'</td>';
                
                //Dimensions
                echo '<td>' . $row7['roomWidth'] . 'x' . $row7['roomLength'] . 'm</td>'; //HOE I CAN REMOVE THE 00 (after pointe)
                
                //Design Category
                $sql3="SELECT category FROM designcategory WHERE id='" .$row7['designCategoryID'] ."'";
                $result3= mysqli_query($connection, $sql3);
                $row3= mysqli_fetch_assoc($result3);
                echo '<td>' . $row3['category'] . '</td>';
                
                //Color Preferences
                echo '<td>' . $row7['colorPreferences'] . '</td>';
                //Requests Date
                echo '<td>' . $row7['date'] . '</td>';
                
                //status of Design Consultation
                $sql4="SELECT * FROM requeststatus WHERE id='" .$row7['statusID'] . "'";
                $result4= mysqli_query($connection, $sql4);
                $row4= mysqli_fetch_assoc($result4);
                // If a consultation provided for a request, then the consultation and its image are shown in the corresponding cell.
                if ($row4['status'] == 'consultation provided') {
                    $sql5="SELECT * FROM designconsultation where requestID='" .$row7['id'] ."'";
                    $result5= mysqli_query($connection, $sql5);
                    $row5= mysqli_fetch_assoc($result5);
                    //echo '<td> <img src="image/' . $row5['consultationImgFileName'] . '" alt="designers Consultation" style="width: 5px; height: 10px;"> <br>' . $row5['consultation'] . '</td>';
                echo '<td> <img src="image/' . $row5['consultationImgFileName'] . '" alt="designers Consultation" "width= 20 height= 15"> <br>' . $row5['consultation'] . '</td>';
                    
                }else{
                    echo "<td>" .$row4['status'] ."</td>";
                }
                echo '</tr>';
            } 
            
            ?>
            </table>
          </main>
          
          <footer>
      <section id="footer">
        <div class="main-footer">
          <div class="Us">
            <h2>Why Us?</h2>
            <ul>
              <li>Industry Knowledge and Trends</li>
              <li>Design Guidance and Consultation</li>
              <li>Wide Range of Products</li>
              <li>Expertise and Experience</li>
            </ul>
          </div>
          <div class="contact">
            <h2>Contact Us</h2>
            <ul>
              <li>
                <a href="mailto:ArtiScape@gmail.com"
                  ><img
                    src="images/Email.png"
                    alt="instgram icon"
                    width="20"
                    height="20"
                  >ArtiScape@gmail.com</a
                >
              </li>
              <li>
                <img
                  src="images/phone.png"
                  alt="phone icon"
                  width="20"
                  height="20"
                >+966555518694
              </li>
            </ul>
          </div>
          <div class="Social">
            <h2>Social Media</h2>
            <ul>
              <li>
                <a href="https://instgram.com"
                  ><img
                    src="images/instgram.png"
                    alt="instgram icon"
                    width="20"
                    height="20"
                  >
                  ArtiScape
                </a>
              </li>
              <li>
                <a href="https://twitter.com"
                  ><img
                    src="images/X.png"
                    alt="X icon"
                    width="20"
                    height="20"
                  >
                  ArtiScape
                </a>
              </li>
              <li>
                <a href="https://www.facebook.com"
                  ><img
                    src="images/Facebook.png"
                    alt="instgram icon"
                    width="20"
                    height="20">
                  ArtiScape
                </a>
              </li>
            </ul>
          </div>
        </div>
        <p>
          Copy right ©2023 made with
          <img src="images/heart.png" alt="love" width="15" height="15"> in
          KSU
        </p>
      </section>
    </footer>
      </body>
          
            </html>