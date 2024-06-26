<!DOCTYPE html>
<html lang="el">
    <head>
    <meta charset="utf-8">
    <title>Designer homepage</title>
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

        td img {
            width: 30%;
        }

        th:not(.noBorder) {
            background-color: #C3B1E1;
        }

        caption {
            float: left;
            font-size: x-large;
        }

        #DInfo { /* Fname, Lname and email  */
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
   
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <script>
$(document).ready(function() {
    // Attach a click event handler to the delete links
    $(document).on('click', '.delete-link', function(e) {
        e.preventDefault();
        var projectId = $(this).data('project-id');

        if (confirm("Are you sure you want to delete this project?")) {
            // Send an AJAX request to the server to delete the project
            $.ajax({
                url: 'PDelete.php',
                type: 'POST',
                data: { projectId: projectId },
                success: function(response) {
                    // If the deletion is successful, remove the table row from the DOM
                    if (response === 'true') {
                        var row = $('#row_' + projectId);
                        if (row.length > 0) {
                            row.remove();
                        }
                    } else {
                        console.log('Failed to delete the project.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if delete request fails
                    console.log(error);
                }
            });
        }
    });
});
</script>
    
<script>
  $(document).ready(function() {
    // Attach a click event handler to the decline links
    $(document).on('click', '.decline-link', function(e) {
        e.preventDefault();
        var requestId = $(this).data('request-id');
        var row = $(this).closest('tr');

        if (confirm("Are you sure you want to decline this consultation request?")) {
            // Send an AJAX request to the server to decline the request
            $.ajax({
                url: 'CUpdate.php',
                type: 'POST',
                data: { requestId: requestId },
                success: function(response) {
                    // If the decline operation is successful, remove the table row from the DOM
                    if (response === 'true') {
                        row.remove();
                    } else {
                        console.log('Failed to decline the request.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if decline request fails
                    console.log(error);
                }
            });
        }
    });
});  

    
 </script>
    
 
    
    
</head>

<body>
<header>
    <nav>
        <a href="Designerhomepage.php"><img id="logo" src="images/Logo.png" alt="Logo"></a>
        <a href="signout.php" id="logout"><img class="log" src="images/logout.png" alt="Logout"></a>
    </nav>
</header>

<main>

    <?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header('Location: index.php');
        exit;
    }
    if ($_SESSION['type'] != 'designer') {
        header('Location: ClientHomepage.php');
        exit;
    }

    $connection = mysqli_connect("localhost", "root", "root", "artiscape");
    if (mysqli_connect_error() != null) {
        echo 'An error occurred in the database connection.';
        die(mysqli_connect_error());
    } else {
        $Sid = $_SESSION['id'];
        $sql1 = "SELECT * FROM designer WHERE id = '$Sid'";
        $result1 = mysqli_query($connection, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
        echo "<h2>Welcome " . $row1['firstName'] . "!</h2>";
        echo '<div id="DInfo">';
        echo '<img src="images/' . $row1['logoImgFileName'] . '" width="250" height="100" alt="">';
        echo '<p>Brand Name: ' . $row1['brandName'] . '</p>';
        echo '<p>Name: ' . $row1['firstName'] . ' ' . $row1['lastName'] . '</p>';
        echo '<p>Email: ' . $row1['emailAddress'] . '</p>';

        $sql2 = "SELECT category FROM designcategory WHERE id IN (SELECT designCategoryID FROM designspeciality WHERE designerID = '$Sid')";
        $result2 = mysqli_query($connection, $sql2);
        $CAT = "";

        $firstCategory = true;
        while ($crow = mysqli_fetch_assoc($result2)) {
            if ($firstCategory) {
                $CAT .= $crow['category'];
                $firstCategory = false;
            } else {
                $CAT .= ',' . $crow['category'];
            }
        }
        echo '<p>Categories: ' . $CAT . '</p>';
        echo '</div>';
        echo '<br>';

        echo '<p id="addProjectLink"><a href="additionpage.php">Add New Project</a></p>';
        echo '<table>';

        echo '<caption>Design Portfolio</caption>';

        echo '<tr>';
        echo '<th>Project Name</th>';
        echo '<th>Image</th>';
        echo '<th>Design category</th>';
        echo '<th>Description</th>';
        echo '<th colspan="2" style="border: none;" class="noBorder"></th>';
        echo '</tr>';

        $sql3 = "SELECT * FROM designportfolioproject WHERE designerID ='$Sid'";
        $result3 = mysqli_query($connection, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)) {
          echo "<tr id='row_" . $row3['id'] . "'>";
            echo "<td>" . $row3['projectName'] . "</td>";
            echo "<td><img src='images/" . $row3['projectImgFileName'] . "'></td>";
            $sql4 = "SELECT * FROM DesignCategory WHERE id=" . $row3['designCategoryID'];
            $result4 = mysqli_query($connection, $sql4);

            $CAT2 = "";
            $firstCategory = true;
            while ($rowcid = mysqli_fetch_assoc($result4)) {
                if ($firstCategory) {
                    $CAT2 .= $rowcid['category'];
                    $firstCategory = false;
                } else {
                    $CAT2 .= ',' . $rowcid['category'];
                }
            }
            echo "<td>" . $CAT2 . "</td>";

            echo "<td>" . $row3['description'] . "</td>";
            echo '<td><a href="updatepage.php?project_id=' . $row3['id'] . '">Edit</a></td>';
            echo "<td class='hover'><a href='#' class='delete-link' data-project-id='" . $row3['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }

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

$sql5 = "SELECT * FROM DesignConsultationRequest WHERE statusID='1' AND designerID ='$Sid'";
$result5 = mysqli_query($connection, $sql5);

if (mysqli_num_rows($result5) > 0) {
    while ($row5 = mysqli_fetch_assoc($result5)) {
        echo "<tr id='row_" . $row5['id'] . "'>";

        // Fetch client details
        $sql4 = "SELECT * FROM client WHERE id =" . $row5['clientID'];
        $result4 = mysqli_query($connection, $sql4);
        $row4 = mysqli_fetch_assoc($result4);
        echo '<td>' . $row4['firstName'] . ' ' . $row4['lastName'] . '</td>';
        
        // Fetch room type
        $sql6 = "SELECT type FROM RoomType WHERE id =" . $row5['roomTypeID'];
        $result6 = mysqli_query($connection, $sql6);
        $row6 = mysqli_fetch_assoc($result6);
        echo '<td>' . $row6['type'] . '</td>';
        
        echo '<td>' . $row5['roomWidth'] . 'x' . $row5['roomLength'] . 'm' . '</td>';
        
        // Fetch design category
        $sql7 = "SELECT category FROM DesignCategory WHERE id=" . $row5['designCategoryID'];
        $result7 = mysqli_query($connection, $sql7);
        $rowC = mysqli_fetch_assoc($result7);
        echo '<td>' . $rowC['category'] . '</td>';
        
        echo '<td>' . $row5['colorPreferences'] . '</td>';
        echo '<td>' . $row5['date'] . '</td>';
        echo '<td><a href="Consultationpage.php?id=' . $row5['id'] . '">Provide Consultation</a></td>';
        echo "<td><a href='#' class='decline-link' data-request-id='" . $row5['id'] . "'>Decline Consultation</a></td>";        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7">No Design Consultation Requests found.</td></tr>';
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
