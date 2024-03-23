<?php
?>
<html lang="el">
<head>
 <meta charset="utf-8">
 <link rel="stylesheet" href="ArtiScape.css">
 <title>signup page</title>
<style>

#top{
    text-align: center;
    margin-top: 10px;
}

form{
    max-width: 500px;
            margin: 10px auto;
            padding: 20px;
            background-color: #E6E6FA;
            border-radius: 5px;
}


          /* Form submit button */
       button{
            background-color: #9678b6;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
          }
        
          /* Form submit button hover effect */
        button:hover {
            background-color: #800080;
          }
          input[type="email"], input[type="password"], input[type="text"]{
        
        width: 50%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
         margin-bottom: 10px;
      }
        input[type="checkbox"], input[type="file"]{
                           margin-bottom: 10px;

          }
          


fieldset{
    border-radius: 5pt;
   
}

#designerform , #clientform{
    display: none;
}

.buttons{
text-align: center;
  
}



</style>

</head>
<body>
    <header>
        <nav>
            <a href="index.html"><img id="logo" src="images/Logo.png" alt="Logo"></a>            
        </nav>
    </header>
    <div id="top">
    <h1>sign up php</h1>


<form method="post" >
<label> User Type:    
<input type="radio" name="type" value="designer" onchange="fun();" > Interior Designer     
 <input type="radio" name="type" value="client" onchange="fun();" > Client
</label>
</form>
<br> 
</div>


<form method="post" action='dsignup.php' id="designerform">
  <fieldset>
<legend> Designer information</legend>
<label>First  name: <input type="text" name="fname"></label> <br>
<label>Last  name: <input type="text" name="lname"></label><br>
<label>Email address: <input type="email" name="email"></label><br>
<label>Password: <input type="password" name="pass"></label><br>
</fieldset>

<br>
<fieldset>
    <legend> Brand information</legend>
    <label>Brand  name: <input type="text" name="brand"></label> <br>
    <label>Logo: <input type="file" name="logo"></label><br>
    
    <label> Speciality: 
        <?php
         $connection= mysqli_connect("localhost", "root", "root", "artiscape");
$error=mysqli_connect_error();
if($error != null){
  die($error);   
}
$sql="SELECT * FROM designcategory ";
 $result= mysqli_query($connection, $sql);
 while( $row = mysqli_fetch_assoc($result))
         echo'<label> <input type="checkbox" name="category[]" value="'.$row['id'].'">'.$row['category'].'</label>';
    
        ?>
     
</fieldset>
    <br>
    <div class="buttons">
      <button type="submit" >signup</button>
    </div>
</form>





<form method="POST" action='csignup.php' id="clientform" >
        <fieldset>
    <legend> Client information</legend>
    <label>First  name: <input type="text" name="fname"></label> <br>
    <label>Last  name: <input type="text" name="lname"></label><br>
    <label>Email address: <input type="email" name="email"></label><br>
    <label>Password: <input type="password" name="pass"></label><br>

</fieldset>
<br>
<div class="buttons">
  <button type="submit" >signup</button>
</div>
    </form>
    <footer style="margin-top:90px">
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
   <script>

function fun(){
    var type = document.getElementsByName("type");
    if(type[0].checked){
        document.getElementById("designerform").style.display="block";
        document.getElementById("clientform").style.display="none";}

        if(type[1].checked){
        document.getElementById("clientform").style.display="block";
        document.getElementById("designerform").style.display="none";
    }
    }

  
 
   </script>
</body>
</html>





