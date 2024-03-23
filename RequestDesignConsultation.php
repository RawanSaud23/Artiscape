<?php
//include 

//errors ( as comment before you submition)
error_reporting(E_ALL);

ini_set('log_errors','1');

ini_set('display_errors','1');

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
            $designerId = $_GET['designer_id'];
            
            //$Did=$_SESSION['id'];
            if ($_SERVER["REQUEST_METHOD"] == "POST") {   
            $Rtype=$_POST['RoomType'];////////////////////
            $width = $_FILES['widthD'];
            $lengthD=$_POST['lengthD'];
            $cat=$_POST['category'];
            $color=$_POST['color'];
            
            $sql = "SELECT id FROM Client WHERE ";///////////incomplete :)
            $result1 = $connection->query($sql);
            if ($result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                $Cid=$row1['id'];
            
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
                
                $sql4="INSERT INTO DesignConsultationRequest (id, clientID, designerID, roomTypeID,
                designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES ((id, $Cid, $designerId, $Rid,
                $Catid, $width, $lengthD, $color, now(), 'pending'))"; //////////////
                
                
                
                if (mysqli_query($connection, $sql4)) {
                // Redirect to homepage after successful insertion
                header("Location: ClientHomepage.php");
                exit();
            }}}
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
                <a href="ClientHomepage.html"><img id="logo" src="images/Logo.png" alt="Logo"></a>            
                <a href="index.html" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>
        </header>
        <main>
           <div class="container">
            <form method="post">
                <?php echo '<input type="hidden" name="designer_id" value="' . $designerId . '">'; ?>
          
                      <label>Room type
                      
                      <select name="RoomType">
                        <option value="LivingR">Living Room</option>
                        <option value="bedroom">bedroom</option>
                        <option value="Kitchen">Kitchen</option>
                      </select></label><br>

                  <label>Room dimension</label>

                      <label>Width: <input type="text" name="widthD" placeholder="(m)"></label>
                      <label>Length: <input type="text" name="lengthD" placeholder="(m)"></label>
                

                  <label>Design category

                  <select name="category">
                    <option value="Modern">Modern</option>
                    <option value="Coasal">Coastal</option>
                    <option value="Country">Country</option>
                    <option value="Bohemian">Bohemian</option>
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