<?php
    require_once 'connect.php';
    session_start();
    $error = "";
    $admin = "admin";

    if(isset($_POST['home'])) {
        header("Location: home.php");
    }
    if(isset($_POST['rentedMovies'])) {
        header("Location: rentedMovies.php");
    }
    if(isset($_POST['rentHistory'])) {
        header("Location: rentHistory.php");
    }
    if(isset($_POST['friends'])) {
        header("Location: friends.php");
    }
    if(isset($_POST['requestNew'])) {
        header("Location: requestNewFilm.php");
    }
    if(isset($_POST['manageFilms'])) {
        header("Location: manageFilms.php");
    }
    if(isset($_POST['manageUsers'])) {
        header("Location: manageUsers.php");
    }
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    .left {
        height: 100%;
        width: 25%;
        position: fixed;
        z-index: 1;
        top: 0;
        overflow-x: hidden;
        padding-top: 20px;
        left: 0;
        background-color: #daf5e9;
        }
        /* Control the right side */
    .right {
        height: 100%;
        width: 75%;
        position: fixed;
        z-index: 1;
        top: 0;
        overflow-x: hidden;
        padding-top: 40px;
        right: 0;
        }      
    b, p {display: inline;}
    .applyButton  {border: none;
                   cursor: pointer;
                   background-color: rgb(245, 233, 218);
                   color: blue;
                   text-decoration-line: underline;
                   font-size: 12px;
                   padding: 0px 12px;}
    .rentButton {border: none;
                   text-align: center;
                   cursor: pointer;
                   background-color: rgb(245, 233, 218);
                   color: red;
                   text-decoration-line: underline;}
    table {border-collapse: collapse;}
    th, td {width:150px;
            text-align:center;
            padding:5px }
    .btn-group button {
        background-color: #daf5e9; 
        border: 1px solid #6294d5; 
        border-style: solid none;
        color: black;
        padding: 10px 24px; 
        cursor: pointer; 
        width: 100%;
        display: block; 
        left: 50%;
        }

    .btn-group button:not(:last-child) {
        border-bottom: none; 
        }

    .btn-group button:hover {
        background-color: rgb(218,230,245);
        }        
        /* Style the search field */

    /* Style the submit button */
    form.example button {
    width: 150px;
    padding: 2px;
    background: #2196F3;
    color: white;
    border: 1px solid grey;
    border-left: none; /* Prevent double borders */
    cursor: pointer;
    }
    form.example button:hover {
    background: #0b7dda;
    }
    
    </style>
</head>
    <body>
        <div class="left">
            <h2><?php echo $_SESSION['sname'] . " " . $_SESSION['surname']; ?></h2>
            <div style="text-align:center;  margin-bottom: 18px;"><p>Wallet: <?php echo $_SESSION['wallet'];?></p></div>
            <form method="post">
            <div class="btn-group">
                <button type="submit" name="home" id="home">Home Page</button>
                <button type="submit" name="rentedMovies" id="rentedMovies">Rented Movies</button>
                <button type="submit" name="rentHistory" id="rentHistory">Rent History</button>
                <button type="submit" name="friends" id="friends">Friends</button>
                <?php if($admin == "admin") echo "<button type=\"submit\" name=\"manageFilms\" id=\"manageFilms\">Manage Films</button>
                <button type=\"submit\" name=\"manageUsers\" id=\"manageUsers\">Manage Users</button>";?>
            </div></form>
        </div>

        <div class="right" >
            <div style="padding:0 10px;">
                <h3 style="text-align: left;">Add film</h3>
                <form method="post" class="example">
                    <input name="title" type="text" size="10" placeholder = "Title">
                    <input name="director" type="numerical" size="10" placeholder = "Director">
                    <input name="genre" type="numerical" size="5" placeholder = "Genre">
                    <input name="year" type="numerical" size="2" placeholder = "Year">
                    <input name="cost" type="numerical" size="1" placeholder = "Cost">
                    <input name="series" type="text" size="10" placeholder = "Series"><br>
                    <textarea wrap="off" cols="30" rows="5" name="comments" id="comments" placeholder="Description" style="width: 495px; resize: none;"></textarea><br>
                    <button name="search" type="submit" style="width:  75px">Add</button>  
                </form>
                <hr style="width: 500px; text-align:left; margin-left:0"> 
                <h3 style="text-align: left;">Requests</h3>
                    <?php
                        if($error == "") {
                            echo "
                            <b>Yusuf Uyar</b><br>
                            <b>Title: </b><p>Ice Age 3</p><b>    Director: </b><p>Carlos Saldanha</p><b>    Genre: </b><p>Comedy</p><b>    Year: </b><p>2009<p><br>
                            <b>Coment: </b><p>Realy good film. Please add</p><br>
                            <form method=\"post\"><button type=\"submit\" name=\"deleteRequest\" class=\"rentButton\">Delete Request</button></form>
                            <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                            echo "
                            <b>Cagri Durgut</b><br>
                            <b>Title: </b><p>3 Idiots</p><b>    Director: </b><p>Rajkumar Hirani</p><b>    Genre: </b><p>Comedy</p><b>    Year: </b><p>2009<p><br>
                            <form method=\"post\"><button type=\"submit\" name=\"deleteRequest\" class=\"rentButton\">Delete Request</button></form>
                            <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                        }
                        else {
                            echo "<p style=\"text-align: left; color: red;\">There are no requests</p>";
                        }
                    ?>
            </div>
        </div>

    </body>  
</html>