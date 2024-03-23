<?php

session_start();
 $fname= $_POST['fname'];
     $lname= $_POST['lname'];
     $email= $_POST['email'];
     $pass= $_POST['pass'];
 $password=password_hash($pass,PASSWORD_DEFAULT);
 $connection= mysqli_connect("localhost", "root", "root", "artiscape");
$error=mysqli_connect_error();
if($error != null){
  die($error);   
}
     $sql="SELECT * FROM client WHERE emailAddress = '$email'";
     $result= mysqli_query($connection, $sql);
 $row = mysqli_fetch_assoc($result);
     if($row == null)
     {
        
     //insert
     $sql="INSERT INTO client (`firstName`, `lastName`, `emailAddress`, `password`) VALUES ( '$fname', '$lname', '$email', '$password');";
     $result= mysqli_query($connection, $sql);
     
     $sql=" SELECT id FROM client where emailAddress = '$email'";
     $result= mysqli_query($connection, $sql);
     $row = mysqli_fetch_assoc($result);
     $id=$row["id"];
         //2 sessions
        $_SESSION["id"]=$id;
        $_SESSION["type"]="client";
         //client homepage 
          header("Location: ClientHomepage.html");
         
     }else{
         echo '<script type ="text/JavaScript">';  
echo'window.location.href="trysignup.php";';
echo 'alert("email already exists");'; 
echo '</script>'; 
 
     }