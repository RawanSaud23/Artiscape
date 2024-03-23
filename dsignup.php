<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
     $fname= $_POST['fname'];
     $lname= $_POST['lname'];
     $email= $_POST['email'];
     $pass= $_POST['pass'];
    
     $password=password_hash($pass,PASSWORD_DEFAULT);
     $brand= $_POST['brand'];
     $logo= $_POST['logo'];
     $category= $_POST['category'];
     
      $connection= mysqli_connect("localhost", "root", "root", "artiscape");
$error=mysqli_connect_error();
if($error != null){
  die($error);   
}
     $sql="SELECT * FROM designer WHERE emailAddress = '$email'";
     $result= mysqli_query($connection, $sql);
 $row = mysqli_fetch_assoc($result);
     if($row == null)
     {
        
     //insert
     $sql="INSERT INTO designer (`firstName`, `lastName`, `emailAddress`, `password`, `brandName`, `logoImgFileName`) VALUES ( '$fname', '$lname', '$email', '$password', '$brand', '$logo');";
     $result= mysqli_query($connection, $sql);
     
     $sql=" SELECT id FROM designer where emailAddress = '$email'";
     $result= mysqli_query($connection, $sql);
     while($row = mysqli_fetch_assoc($result)){
     $id=$row["id"];}
     
        //speciality
     foreach ($category as $value) {
      $sql="INSERT INTO designspeciality (`designerID`, `designCategoryID`) VALUES ('$id', '$value')";
     $result= mysqli_query($connection, $sql);   
     }
  
         //2 sessions
        $_SESSION["id"]=$id;
        $_SESSION["type"]="designer";
        
         //designer homepage 
          header("Location: Designerhomepage.html");
         
     }else{
         echo '<script type ="text/JavaScript">';  
echo'window.location.href="trysignup.php";';
echo 'alert("email already exists");'; 
echo '</script>'; 
 
     }
        ?>
    </body>
</html>
