<!DOCTYPE html>
<html lang="el">
    <head>
        <title>Addition page</title>
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

 $Did=$_SESSION['id'];
 if ($_SERVER["REQUEST_METHOD"] == "POST") {   
$pname=$_POST['projectName'];
$image = $_FILES['projectImage']['name'];
$des=$_POST['description'];
$cat=$_POST['category'];

$sql = "SELECT id FROM designcategory WHERE category='$cat'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id=$row['id'];
 

    $sql = "INSERT INTO designportfolioproject ( designerID ,projectName, projectImgFileName, description, designCategoryID )
    VALUES ($Did,'$pname', '$image','$des' ,'$id')";
 //$Did iam not sure i need to link it with reem to test it.
     if (mysqli_query($conn, $sql)) {
        // Redirect to homepage after successful insertion
        header("Location: index.php");
        exit();
    }
    
}
 }

        
    ?>
        <header>
            <nav>
                <a href="Designerhomepage.html"><img id="logo" src="images/Logo.png" alt="Logo"></a> 
                <a href="signout.php" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>
        </header>
        
        <main>
           <div class="container">
            <form method="POST" action="additionpage.php" enctype="multipart/form-data">
          
                      <label >Project name
                        <input type="text" name="projectName">
                      </label> <br>

                  <label >Project image

                    <input type="file" name="projectImage"> 
                </label><br>

                  <label >Design category

                  <select name="category">
            <option value="Modern">Modern</option>
            <option value="Coastal">Coastal</option>
            <option value="Country">Country</option>
            <option value="Bohemian">Bohemian</option>
        </select></label><br>

                  <label >Description

                  <textarea name="description" ></textarea></label><br>

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


