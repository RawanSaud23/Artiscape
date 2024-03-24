
<!DOCTYPE html>
<html lang="el">
    <head>
        <title>Consultation page</title>
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
          input[type="text"],textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
          }
        
          /* Form submit button */
          input[type="submit"] {
            background-color: #9678b6;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
          }
        
          /* Form submit button hover effect */
          input[type="submit"]:hover {
            background-color: #800080;
          }
          #Requestinfo{
        margin:auto;
        text-align: left;
        padding: .5% .5%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
        </style>
    </head>
    <body>
     <?php   
     
        session_start();
if (!isset($_SESSION['id'])|| $_SESSION['type']!='designer') {
    header('Location: index.php');
    exit;
} 
    $conn = mysqli_connect('localhost', 'root', 'root','artiscape');

 
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
 // Check if request ID is present in the query string
if (isset($_GET['id'])) {
    $request_id = $_GET['id'];
   // 
    // Retrieve request information based on the requestID
    $sql = "SELECT * FROM designconsultationrequest WHERE id =".$request_id;
    $result = mysqli_query($conn, $sql);
    $request = mysqli_fetch_assoc($result);
    // id=$request_id
    
    $sql2="SELECT * FROM client WHERE id=".$request['clientID'];
    $result2 = mysqli_query($conn, $sql2);
    $request2 = mysqli_fetch_assoc($result2);
    
    $sql3="SELECT * FROM roomtype WHERE id=".$request['roomTypeID'];
    $result3 = mysqli_query($conn, $sql3);
    $request3 = mysqli_fetch_assoc($result3);
    
    $sql4="SELECT category FROM designcategory WHERE id=".$request['designCategoryID'];
    $result4 = mysqli_query($conn, $sql4);
    $request4 = mysqli_fetch_assoc($result4);    
        
      } 
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {   
        
        $con=$_POST['consultation'];
        $image = $_FILES['image']['name'];
        
         $sql7="SELECT id FROM requeststatus WHERE status='consultation provided'";
         $result7 = mysqli_query($conn, $sql7);
         $request7 = mysqli_fetch_assoc($result7);  
         $sql = "UPDATE designconsultationrequest SET statusID='".$request7['id']."' WHERE id=".$request_id;
        $conn->query($sql);

    
        //id=$requested_id
        $sql6="INSERT INTO designconsultation ( requestID ,consultation, consultationImgFileName )
    VALUES ('$request_id','$con', '$image')";
 //in 2 place we should put $request_id
     if (mysqli_query($conn, $sql6)) {
        // Redirect to designer's homepage after successful insertion
        header("Location: index.php");
        exit();
    }
    }
    
       ?> 
        
        <header>
            <nav>
                <a href="Designerhomepage.php"><img id="logo" src="images/Logo.png" alt="Logo"></a> 
                <a href="signout.php" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>
        </header>
        
        <main>
           <div class="container">
            
          
               Request Information <br><br>
                      
                      <div id="Requestinfo">
                        Client: <?PHP   echo $request2['firstName']." ".$request2['lastName']    ?><br>
                        Room: <?PHP     echo $request3['type']       ?><br>
                        Dimensions: <?PHP  echo $request['roomWidth']."*".$request['roomLength']     ?><br>
                        Design category: <?PHP  echo $request4['category']         ?><br>
                        Color Preferences: <?PHP    echo $request['colorPreferences']     ?><br>
                        Date: <?PHP  echo $request['date']       ?>
        
                    </div>
                      
                      <br>
                      <form method="post" action="Consultationpage.php" enctype="multipart/form-data">
                          <input type="hidden" name="request_id" value="<?php echo isset($request_id)?$request_id:''; ?>">   <!-- iam not sure  -->
                  <label >Consultation:

                  <textarea name="consultation"></textarea></label><br>
                  <label>Upload Image:</label>
                  <input type="file" name="image" ><br><br>

                  <input type="submit" value="Submit" >
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



