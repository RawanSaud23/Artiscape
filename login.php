<?php
     $connection= mysqli_connect("localhost", "root", "root", "artiscape");
$error=mysqli_connect_error();
if($error != null){
die($error); } 
  
 session_start();
 
  $email= $_POST['email'];
  $pass= $_POST['pass'];
  $type= $_POST['type'];
   
if($type == "designer"){
 $sql="SELECT * FROM designer WHERE emailAddress = '$email'";
      $result= mysqli_query($connection, $sql);
 $row = mysqli_fetch_assoc($result);
  if($row == null){
     echo '<script type ="text/JavaScript">';  
echo'window.location.href="login.php";';
echo 'alert("email doesnt exist");';
echo '</script>'; 
   
  }else{
     if(password_verify($pass, $row["password"])) {
       $_SESSION["id"]=$row['id'];
        $_SESSION["type"]="designer";   
     header("Location: Designerhomepage.php");
     
     } else{
             echo '<script type ="text/JavaScript">';  
echo'window.location.href="login.php";';
echo 'alert("wrong password");';
echo '</script>'; 
             
         }
         
    }
      
      
  }elseif($type == "client"){
       $sql="SELECT * FROM client WHERE emailAddress = '$email'";
      $result= mysqli_query($connection, $sql);
 $row = mysqli_fetch_assoc($result);
  if($row == null){
     echo '<script type ="text/JavaScript">';  
echo'window.location.href="login.php";';
echo 'alert("email doesnt exist");';
echo '</script>'; 
   
  }else{
     if(password_verify($pass, $row["password"])) {
       $_SESSION["id"]=$row['id'];
        $_SESSION["type"]="client";
     header("Location: clientHomepage.php");
     
     } else{
             echo '<script type ="text/JavaScript">';  
echo'window.location.href="login.php";';
echo 'alert("wrong password");'; 
echo '</script>'; 
             
         }

} 
  }
