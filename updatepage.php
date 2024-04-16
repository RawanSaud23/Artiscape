<?php
//errors ( as comment before you submition)
error_reporting(E_ALL);

ini_set('log_errors','1');

ini_set('display_errors','1');
?>
<!DOCTYPE html>
<html lang="el">
    <head>
        <title>Update page</title>
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

// Check if project ID is present in the query string
//if (isset($_GET['project_id'])) {
    $project_id = '2';
  
    // Retrieve project information based on the project ID
    $sql = "SELECT * FROM designportfolioproject WHERE id =".$project_id ;
    $result = mysqli_query($conn, $sql);
    $project = mysqli_fetch_assoc($result);
    // change id=$project_id 
    
    $sql2="SELECT category FROM designcategory WHERE id=".$project['designCategoryID'];
    $result2 = mysqli_query($conn, $sql2);
    $project2 = mysqli_fetch_assoc($result2);
    
    
  
    
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
echo $project_id;
$pname=$_POST['projectName'];
$image = $_FILES['projectImage']['name'];
$des=$_POST['description'];
$cat=$_POST['category'];

$sql = "SELECT id FROM designcategory WHERE category='$cat'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id=$row['id'];
 
    // Check if a new image is uploaded
        if ($_FILES['projectImage']['error'] === UPLOAD_ERR_OK) {
            // File is uploaded, handle the file upload
            $image = $_FILES['projectImage']['name'];
            // Handle file upload and move to destination folder
            $target_path = "uploads" . $image; // Update with your destination folder path  
        } 
        else {
            // No new image uploaded, retain the current image filename
            $sql = "SELECT projectImgFileName FROM designportfolioproject WHERE id=".$project_id;
            //i need change id
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $image = $row['projectImgFileName'];
            } 
        }

        // Update project details in the database
        $sql = "UPDATE designportfolioproject SET projectName='$pname', designCategoryID='$id', description='$des', projectImgFileName='$image' WHERE id=".$project_id; // Update the WHERE condition as needed

        if (mysqli_query($conn, $sql)) {
            // Redirect to homepage after successful update
            header("Location: DesignerHomepage.php");
            exit();
        } 
    
}}//}


 
        ?>
        <header>
            <nav>
                <a href="Designerhomepage.php"><img id="logo" src="images/Logo.png" alt="Logo"></a> 
                <a href="index.html" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>
        </header>
        
        <main>
           <div class="container">
            <form method="post" action="updatepage.php" enctype="multipart/form-data">
               <input type="hidden" name="projectid" value="<?php echo isset($project_id)?$project_id:''; ?>">   <!-- iam not sure  -->
                      <label >Project name
                        <input type="text" name="projectName" value="<?php echo isset($project['projectName']) ? $project['projectName'] : ''; ?>">
                      </label> <br>

                  <label >Project image

                      <input type="file" name="projectImage"><!-- cannot it say bec of security --> 
                </label><br>

                  <label >Design category

                    <select name="category">
                      <option value="Modern"     <?php  echo isset($project2['category']) && $project2['category'] == 'Modern' ? 'selected' : '';  ?>      >Modern</option>
                      <option value="Coastal"    <?php  echo isset($project2['category']) && $project2['category'] == 'Coastal' ? 'selected' : '';  ?>     >Coastal</option>
                      <option value="country"    <?php  echo isset($project2['category']) && $project2['category'] == 'Country' ? 'selected' : '';  ?>     >Country</option>
                      <option value="Bohemian"   <?php  echo isset($project2['category']) && $project2['category'] == 'Bohemian' ? 'selected' : '';  ?>    >Bohemian</option>
                    </select></label><br>

                  <label >Description

                      <textarea name="description"><?php echo isset($project['description']) ? $project['description'] : ''; ?></textarea></label>

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