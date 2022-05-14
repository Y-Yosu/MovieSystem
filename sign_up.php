<?php
    require_once 'connect.php';
    session_start();
    $error = "";
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        
    h1,h2,h3{text-align: center; 
        line-height:1.2;}
    body {background-color: rgb(245, 233, 218);
          max-width:60%;
          margin:40px auto;
          font-size:18px;
          line-height:1.6;
          color:#444;
          padding:0 10px;}
    div {text-align: center;}
    p {text-align: center;}
    </style>
</head>
    <body>
        <h2>Create Account</h2>
        <p class="error" style="color: red;" ><?php echo $error; ?></p>
        <form method="post" style="text-align: center;">
            Email <input name="sname" type="text" required style="margin-top: 15px; margin-left: 28px"><br>
            Name <input name="sname" type="text" required style="margin-top: 10px;margin-left: 26px"><br>
            Surname <input name="sname" type="text" required style="margin-top: 10px;margin-left: 6px"><br>
            Password <input name="sid" type="numerical" required style="margin-top: 15px;"><br>
            <button name="submit" type="submit" style="margin-top: 15px;">Sign in</button>             
        </form>
    </body>  
</html>