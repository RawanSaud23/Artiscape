<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="utf-8">
        <title>Designer homepage</title>
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
                width: 30%;
            }
            th:not(.noBorder){
                background-color: #C3B1E1;
            }
            caption{
                float: left;
                font-size:x-large;
            }
            #DInfo{ /* Fname, Lname and email  */
                background-color: #E6E6FA;
                padding: 5px;
                margin: auto;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
            }

             #addProjectLink {
                float: right;
                margin-right: 1em;
             }
             
        </style>
        
      </head>

      <body>
        <header>
            <nav>
                <a href="Designerhomepage.html"><img id="logo" src="images/Logo.png" alt="Logo"></a>
                <a href="index.html" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
            </nav>  
          </header>

        <main>

            <?php
            session_start();
       //if (!isset($_SESSION['id'])) {
        //header('Location: index.php');
        //exit;
        //}
        //if ($_SESSION['type'] != 'designer') {
         //header('Location: ClientHomepage.php');
         //exit;
        //}  
        
$connection = mysqli_connect("localhost", "root", "root", "artiscape");
if (mysqli_connect_error() != null) {
    echo 'An error occurred in the database connection.';
    die(mysqli_connect_error());
} else {
    //$Sid = $_SESSION['id'];
    $sql1 = "SELECT * FROM designer WHERE id = '1'";//نبدله $Sid
    $result1 = mysqli_query($connection, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    echo "<h2>Welcome " . $row1['firstName'] . "!</h2>";
    echo '<div id="DInfo">';
    echo '<img src="images/' . $row1['projectImgFileName'] . '" width="250" height="100" alt="">';
    echo '<p>Brand Name: ' . $row1['brandName'] . '</p>';
    echo '<p>Name: ' . $row1['firstName'] . ' ' . $row1['lastName'] . '</p>';
    echo '<p>Email: ' . $row1['emailAddress'] . '</p>';
    $sql2 = "SELECT category FROM designcategory WHERE id =" . $row1['id'];
    $result2 = mysqli_query($connection, $sql2);
    $Crow = mysqli_fetch_assoc($result2);
    echo '<p>Categories: ' . $Crow['category'] . '</p>';
    echo '</div>';
    echo '<br>';

    echo '<p id="addProjectLink"><a href="additionpage.html">Add New Project</a></p>';
    echo '<table>';

    echo '<caption>Design Portfolio</caption>';

    echo '<tr>';
    echo '<th>Project Name</th>';
    echo '<th>Image</th>';
    echo '<th>Design category</th>';
    echo '<th>Description</th>';
    echo '<th colspan="2" style="border: none;" class="noBorder"></th>';
    echo '</tr>';

    $sql3 = "SELECT * FROM designportfolioproject WHERE designerID ='1'";//نبدله $Sid
    $result3 = mysqli_query($connection, $sql3);
    while ($row3 = mysqli_fetch_assoc($result3)) {
        echo "<tr>";
        echo "<td>" . $row3['projectName'] . "</td>";
        echo "<td><img src='images/" . $row3['projectImgFileName'] . "'></td>";
        $sql4 = "SELECT * FROM DesignCategory WHERE id=" . $row3['designCategoryID'];
        $result4 = mysqli_query($connection, $sql4);
        $rowcid = mysqli_fetch_assoc($result4);
        echo "<td>" . $rowcid['category'] . "</td>";
        echo "<td>" . $row3['description'] . "</td>";
        echo '<td><a href="updatepage.php">Edit</a></td>';
        echo "<td class='hover'><a href='PDelete.php?project_id=" . $row3['id'] . "'>Delete</a></td>";
        echo "</tr>";
    }

    echo '</table>';
    echo '<table>';
    echo '<caption style="margin-top: 1em;">Design Consultation Requests</caption>';

    echo '<tr>';
    echo '<th>Client</th>';
    echo '<th>Room</th>';
    echo '<th>Dimensions</th>';
    echo '<th>Design Category</th>';
    echo '<th>Color Preferences</th>';
    echo '<th>Date</th>';
    echo '<th colspan="2" style="border: none;" class="noBorder"></th>';
    echo '</tr>';

    $sql5 = "SELECT * FROM DesignConsultationRequest WHERE id ='1'";//نبدله $Sid
    $result5 = mysqli_query($connection, $sql5);
    while ($row5 = mysqli_fetch_assoc($result5)) {
        echo '<tr>';
        $sql4 = "SELECT * FROM Client WHERE id ='1'";//نبدله $Sid
        $result4 = mysqli_query($connection, $sql4);
        $row4 = mysqli_fetch_assoc($result4);
        echo '<td>' . $row4['firstName'] . ' ' . $row4['lastName'] . '</td>';
        $sql6 = "SELECT type FROM RoomType WHERE id =" . $row5['roomTypeID'];
        $result6 = mysqli_query($connection, $sql6);
        $row6 = mysqli_fetch_assoc($result6);
        echo '<td>' . $row6['type'] . '</td>';
        echo '<td>' . $row5['roomWidth'] . 'x' . $row5['roomLength'] . 'm' . '</td>';
        $sql7 = "SELECT * FROM DesignCategory WHERE id=" . $row5['designCategoryID'];
        $result7 = mysqli_query($connection, $sql7);
        $rowC = mysqli_fetch_assoc($result7);
        echo '<td>' . $rowC['category'] . '</td>';
        echo '<td>' . $row5['colorPreferences'] . '</td>';
        echo '<td>' . $row5['date'] . '</td>';
        echo '<td><a href="Consultationpage.html">Provide Consultation</a></td>';
        echo '<td><a href="CDelete.php?delete_id=' . $row5['id'] . '">Decline Consultation</a></td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
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


