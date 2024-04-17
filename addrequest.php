<?php
// Errors (as comment before you submission)
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', '1');

session_start();

// Validate user type and get his/her id
if(isset($_SESSION['id']) && $_SESSION['type'] != 'designer'){
    $ClientID = $_SESSION['id'];
    $userType = $_SESSION['type'];
} else {
    // Display an error message
    echo "Cannot find the client ID";
    exit;
}

// Redirect if the user is a designer
if($_SESSION['type'] == 'designer'){
    header("Location: index.php");
    exit();
}

$connection = mysqli_connect('localhost', 'root', 'root', 'artiscape');

// Error handling
$error = mysqli_connect_error();
if($error != null){                                                          
    exit('Database connection failed');                                      
}

// Get user Consultation request
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $Rtype = $_POST['RoomType'];
    $width = floatval($_POST['widthD']);
    $lengthD = floatval($_POST['lengthD']);
    $cat = $_POST['category'];
    $color = $_POST['color'];
    $id2 = $_POST['Designer-ID'];  // From the hidden button

    // Check if room type exists
    $sql800 = "SELECT id FROM roomtype WHERE type ='$Rtype'";
    $result800 = mysqli_query($connection, $sql800);
    $row800 = mysqli_fetch_assoc($result800);

    if(!$row800) {
        echo "Error: Room type does not exist.";
        exit();
    }

    $roomTypeID = $row800['id'];

    // Check if design category exists
    $sql700 = "SELECT id FROM designcategory WHERE category ='$cat'";
    $result700 = mysqli_query($connection, $sql700);
    $row700 = mysqli_fetch_assoc($result700);

    if(!$row700) {
        echo "Error: Design category does not exist.";
        exit();
    }

    $designCategoryID3 = $row700['id'];

    $currentDate = date('Y-m-d');

    $sql4 = "INSERT INTO designconsultationrequest (clientID, designerID, roomTypeID, designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) 
             VALUES ('$ClientID', '$id2', '$roomTypeID', '$designCategoryID3', '$width', '$lengthD', '$color', '$currentDate', '1')";

    $result4 = mysqli_query($connection, $sql4);

    if($result4) {
        echo "<script> alert('Successfully added'); </script>";
        // Redirect to homepage after successful insertion
        header("Location: ClientHomepage.php");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($connection);
    }
}
?>
