<?php
?>
<html lang="el">
<head>
 <meta charset="utf-8">
 <link rel="stylesheet" href="ArtiScape.css">
 <title>home page</title>
<style>

#login {
text-align: center;
border-radius: 10pt ;
max-width: 500px;
margin: 10px auto;
 padding: 40px;
 background-color: #E6E6FA;
 border-radius: 5px;
margin-bottom: 2em;
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
       
      }

p{
 margin-top: 2em;  
    
}
h1{
    margin-top: 1em;
 text-align: center;
 
}
a{
 color: black;
}

</style>

</head>
<body>
    <header>
        <nav>
            
            <a href="index.php"><img id="logo" src="images/Logo.png" alt="Logo"></a> 
        </nav>
        
    </header>
    <h1> Artiscape Interior</h1>
 <div id="login"> 
  
   
   <button type="button" onclick="window.location.href='login.html'">Login</button>

<p>New User? <a href="signup.php"> Sign-up</a>  </p>

</div>
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
