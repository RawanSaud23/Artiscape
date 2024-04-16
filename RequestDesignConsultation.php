<?php
//errors ( as comment before you submition)
//error_reporting(E_ALL);
//
//ini_set('log_errors','1');
//
//ini_set('display_errors','1');

            //session_start();                       
           //validate user type and get his/her id
            //if(isset($_SESSION['id']) || isset($_SESSION['type'])!='designer'){
              //  $ClientID= $_SESSION['id'];
                //$userType= $_SESSION['type'];
            //}
            
            //if(!isset($_SESSION['id'])){ //when the user is designer
              //  header("Location: index.php");
                //exit();
            //} 
          
            $connection= mysqli_connect('localhost','root', 'root', 'artiscape');
            
            //error handling
            $error= mysqli_connect_error();
            if ($error!=null){                                                          
                exit('database cannot found');                                      
            }
//             if (isset($_GET['id'])){
//                $designerId = $_GET['DesignerID'];
//            } 
//            
             //Retrieve the designer ID from the query string
            if (isset($_GET['DesignerID'])){
            $designerId3 = $_GET['DesignerID'];
            } // if get
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
          input[type="text"], select, input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
          }
        
          /* Form submit button */
          #submit {
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
            <form action="addrequest.php" method="POST">
               
                <input type="hidden" name="Designer-ID" value="<?php echo $designerId3; ?>">
                      <label>Room type</label>         
                        <?php 
                        $sql="SELECT type FROM roomtype ";
                        $result= mysqli_query($connection, $sql);
                        ?>
                      <select name="RoomType">
                          <?php
                        while ($row = mysqli_fetch_assoc($result)){
                            echo '<option value=' .$row["type"] .'>' .$row['type'] .'</option>';
                        } ?>
                      </select><br>

                  <label>Room dimension</label>

                      <label>Width: </label><input type="number" name="widthD" placeholder="(m)">
                      <label>Length: </label><input type="number" name="lengthD" placeholder="(m)">
                

                  <label>Design category</label>
                        <?php 
                        $sqlC="SELECT category FROM designcategory ";
                        $resultC= mysqli_query($connection, $sqlC);
                        ?>
                  <select name="category">
                      <?php
                        while ($rowC = mysqli_fetch_assoc($resultC)){
                            echo '<option value=' .$rowC["category"] .'>' .$rowC['category'] .'</option>';
                        } ?>
                  </select><br>

                  <label>Color Preferences

                      <input type="text" name="color"></label><br>
                      
                      <input type="submit" value="Submit" id="submit">
                      
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