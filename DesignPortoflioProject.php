<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Design Portfolio</title>
        <link rel="stylesheet" href="ArtiScape.css">
        <style>
            table{
                border-collapse: collapse;
                width: 100%;
            }
            th, td{
                border: 1px solid black;
                text-align: center;
            }
            td{
                height: 70px;
            }
            td img{
                width: 40%;
            }
            th {
                background-color: #C3B1E1;
            }
            caption{
                font-size:x-large;
                text-align: left;
                margin-bottom: 1em;
            }
            #DInfo{
                background-color: #E6E6FA;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
            }

        </style>
    </head>
    <body>
        <header>
            <nav>
                <a href="Designerhomepage.php"><img id="logo" src="images/Logo.png" alt="Logo"></a>
                <a href="signout.php" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>  
          </header>
        <?php
        
        session_start();
        if (!isset($_SESSION['id'])) {
        header('Location: index.php');
        exit;
        } 

        $connection= mysqli_connect("localhost","root","root","artiscape");
        if(mysqli_connect_error()!= null){
            echo'An error occur in database connection';
            die(mysqli_conncet_error());}
        else{
            $id=$_GET['id'];
            $sql1 = "SELECT * FROM designportfolioproject WHERE designerID ='$id'";
            $result1 = mysqli_query($connection, $sql1);
            
            echo "<table>";
            echo "<caption>Design Portfolio</caption>";
            echo "<tr>";
            echo "<th>Project Name</th>";
            echo "<th>Image</th>";
            echo "<th>Design category</th>";
            echo "<th>Description</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result1)){
               echo "<tr>";
               echo "<td>" . $row['projectName'] . "</td>";
               echo "<td><img src='images/" . $row['projectImgFileName'] . "'></td>";
               $sql2= "SELECT * FROM DesignCategory WHERE id=".$row['designCategoryID'];
               $result2 = mysqli_query($connection, $sql2);
               $rowcid = mysqli_fetch_assoc($result2);
               echo "<td>" . $rowcid['category'] . "</td>";
               echo "<td>" . $row['description'] . "</td>";
               echo "</tr>"; 
            }

                echo "</table>";

            }
            ?>
        
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

