<?php
    
    require_once 'connect.php';
    session_start();

    $error = "";
    
    if(isset($_POST['submit'])) {
        $name = $str = ucfirst(strtolower($_POST['sname']));
        $password = $_POST['sid'];
        $surname = "Polo";
        $mail = "marcopolo@gmail.com";
        $wallet = "100$";

        $query = "SELECT sname, sid FROM student WHERE sname = '$name' and sid = '$password'";
        $result = mysqli_query($con, $query);
        if($result == true) 
            $count = mysqli_num_rows($result);
        if($result == true && $count == 1){
            $error = "";
            $_SESSION['sname'] = $name;
            $_SESSION['surname'] = $surname;
            $_SESSION['sid'] = $password;
            $_SESSION['mail'] = $mail;
            $_SESSION['wallet'] = $wallet;
            header("Location: home.php"); 
        }
        else{
            $error = "Invalid User"; 
        }
    }
    if(isset($_POST['sign_up'])) {
        header("Location: sign_up.php");
    }
    if(isset($_POST['forget'])) {
        header("Location: newPassword.php");
    }
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
    .applyButton  {border: none;
                   text-align: center;
                   cursor: pointer;
                   background-color: rgb(245, 233, 218);
                   color: blue;
                   text-decoration-line: underline;
                   font-size: 10px;
                   padding: 0px 12px;}
    </style>
</head>
    <body>
        <h2>Login Page</h2>
        <p class="error" style="color: red;" ><?php echo $error; ?></p>
        <form method="post" style="text-align: center;">
            Email <input name="sname" type="text" required style="margin-top: 10px; margin-left: 26px"><br>
            Password <input name="sid" type="numerical" required style="margin-top: 15px;"><br>
            <button name="submit" type="submit" style="margin-top: 15px;">Login</button>  
        </form>
        <form method="post" style="text-align: center;"><button type="submit" name="forget" class="applyButton" style="margin-right: 155px;">Forgot my password</button><br>
        <button type="submit" name="sign_up" class="applyButton" style="margin-right: 68px;">Don't have an account? Create new one</button></form>
    </body>  
</html>