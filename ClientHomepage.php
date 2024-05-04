<?php
session_start();

// Validate user type and ensure the user is not a designer
if (!isset($_SESSION['id']) || $_SESSION['type'] == 'designer') {
    header("Location: index.php");
    exit();
}

$ClientID = $_SESSION['id'];
$userType = $_SESSION['type'];

// DB connection
$connection = mysqli_connect('localhost', 'root', 'root', 'artiscape');
if (mysqli_connect_error()) {
    exit('Database connection failed: ' . mysqli_connect_error());
}

// Fetch client info
$sql = "SELECT * FROM client WHERE id='$ClientID'";
$result = mysqli_query($connection, $sql);
$client = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Client Homepage</title>
    <link rel="stylesheet" href="ArtiScape.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
        }
        td {
            height: 70px;
        }
        th:not(#noBorder) {
            background-color: #C3B1E1;
        }
        caption {
            float: left;
            font-size: x-large;
        }
        #ClientInfo {
            background-color: #E6E6FA;
            padding: 5px;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
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
    <h2>Welcome <?php echo htmlspecialchars($client['firstName']); ?>!</h2>
    <div id="ClientInfo">
        <p>Name: <?php echo htmlspecialchars($client['firstName'] . ' ' . $client['lastName']); ?></p>
        <p>Email: <?php echo htmlspecialchars($client['emailAddress']); ?></p>
    </div>

    <label for="categorySelect">Select Category:</label>
    <select name="category" id="categorySelect" onchange="fetchDesigners()">
        <option value="">Select a Category</option>
        <?php
        $sql_category = "SELECT * FROM designcategory";
        $result_category = mysqli_query($connection, $sql_category);
        while ($row = mysqli_fetch_assoc($result_category)) {
            echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
        }
        ?>
    </select>

    <table id="designersTable">
        <caption>Interior Designers</caption>
        <tr>
            <th>Designer</th>
            <th>Specialty</th>
            <th style="border: none;" id="noBorder"></th>
        </tr>
    </table>
    
    
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
                echo '<td>' . $row7['roomWidth'] . 'x' . $row7['roomLength'] . 'm</td>'; 
                
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
                echo '<td> <img src="images/' . $row5['consultationImgFileName'] . '" alt="designers Consultation"> <br>' . $row5['consultation'] . '</td>';
               
                }else{
                    echo "<td>" .$row4['status'] ."</td>";
                }
                echo '</tr>';
            } 
            
            ?>
            </table>
</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetchDesigners(); // Load all designers on page load
});

function fetchDesigners() {
    var categoryId = document.getElementById('categorySelect').value;
    console.log("Fetching designers for category:", categoryId); // Debug: Log category ID

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getDesigners.php?category=' + categoryId, true);
    xhr.onload = function () {
        if (this.status == 200) {
            console.log("Response received:", this.responseText); // Debug: Log response
            try {
                var designers = JSON.parse(this.responseText);
                var output = '<tr><th>Designer</th><th>Specialty</th><th></th></tr>';
                designers.forEach(function (designer) {
                    output += '<tr>' +
                        '<td><a href="DesignPortoflioProject.php?id=' + designer.id + '"><img src="' + designer.logoImgFileName + '" alt="' + designer.brandName + '"><br>' + designer.brandName + '</a></td>' +
                        '<td>' + designer.category + '</td>' +
                        '<td><a href="RequestDesignConsultation.php?DesignerID=' + designer.id + '">Request Design Consultation</a></td>' +
                        '</tr>';
                });
                document.getElementById('designersTable').innerHTML = output;
            } catch (e) {
                console.error("Error parsing JSON:", e); // Debug: Log JSON parsing error
            }
        } else {
            console.error("Failed to fetch designers:", this.status); // Debug: Log HTTP error
        }
    };
    xhr.onerror = function () {
        console.error("Request failed"); // Debug: Log network error
    };
    xhr.send();
}
</script>         
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