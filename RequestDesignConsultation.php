<?php
//include 

//errors ( as comment before you submition)
error_reporting(E_ALL);

ini_set('log_errors','1');

ini_set('display_errors','1');

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
            
            $designerId = $_GET['DesignerID'];

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
                
                $sql4="INSERT INTO designconsultationrequest ( clientID, designerID, roomTypeID,
                designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES (( $Cid, $designerId, $Rid,
                $Catid, $width, $lengthD, $color, date(Y-m-d), '1'))"; //////////////

                if (mysqli_query($connection, $sql4)) {
                // Redirect to homepage after successful insertion
                header("Location: ClientHomepage.php");
                exit();
            }}
            }
            
            }//POST///
?>

<!DOCTYPE html>
<html lang="el">
    <head>
        <title>Consultation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="ArtiScape.css">
        <style>
          /* Form container */
          .container {
            max-width: 500px;
            margin: 10px auto;
            padding: 20px;
            background-color: #E6E6FA;
            border-radius: 5px;
          }
        
          /* Form labels */
          label {
            display: block;
            margin-bottom: 10px;
          }
        
          /* Form inputs */
          input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
          }
        
          /* Form submit button */
          button {
            background-color: #9678b6;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
          }
        
          /* Form submit button hover effect */
          button:hover {
            background-color: #800080;
          }
        </style>
    </head>
    <body>
        
        <header>
            <nav>
                <a href="ClientHomepage.php"><img id="logo" src="images/Logo.png" alt="Logo"></a>            
                <a href="signout.php" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>
        </header>
        <main>
           <div class="container">
            <form method="POST" action="ClientHomepage.php">
               
                <?php echo '<input type="hidden" name="DesignerID" value="' . $designerId . '">'; ?>
          
                      <label>Room type         
                        <?php 
                        $sql="SELECT type FROM roomtype ";
                        $result= mysqli_query($connection, $sql);
                        ?>
                      <select name="RoomType">
                          <?php
                        while ($row = mysqli_fetch_assoc($result)){
                            echo '<option value=' .$row["type"] .'>' .$row['type'] .'</option>';
                        } ?>
                      </select></label><br>

                  <label>Room dimension</label>

                      <label>Width: <input type="text" name="widthD" placeholder="(m)"></label>
                      <label>Length: <input type="text" name="lengthD" placeholder="(m)"></label>
                

                  <label>Design category
                        <?php 
                        $sqlC="SELECT category FROM designcategory ";
                        $resultC= mysqli_query($connection, $sqlC);
                        ?>
                  <select name="category">
                      <?php
                        while ($rowC = mysqli_fetch_assoc($resultC)){
                            echo '<option value=' .$rowC["category"] .'>' .$rowC['category'] .'</option>';
                        } ?>
                  </select></label><br>

                  <label>Color Preferences

                      <input type="color" name="color"></label><br>
                      
                      <button type="button">Submit</button>

            </form>
          </div>
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