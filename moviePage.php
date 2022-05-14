<?php
    session_start();
    $error = "";
    $admin = "admin";

    $title = "Psycho";
    $director = "Alfred Hitchcock";
    $genre = "Horror";
    $year = "1960";
    $rate = "8.2";
    $cost = "50$";
    $description = "Psycho is Hitchcock's most widely known film. It centers around a woman named Marion Crane (played by Janet Leigh), who steals $40,000 from her employer so she can run away with the man she loves and start a new life. ";
    $rentStatus = "";


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
    <?php include 'stars.css'; ?>
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
        padding-top: 10px;
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
                   text-decoration-line: underline;
                   font-size : 16px;}
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
                <h1 style="text-align: center;"><?php echo $title; ?></h1>
                <div style="text-align: center;">
                <b>Director: </b><p><?php echo $director; ?></p>
                <b style="margin-left: 15px">Genre: </b><p><?php echo $genre; ?></p>
                <b style="margin-left: 15px">Year: </b><p> <?php echo $year; ?></p>
                <b style="margin-left: 15px">Rate: </b><p> <?php echo $rate; ?></p></div><br>
                <b>Description: </b><p> <?php echo $description; ?></p>
                <form method="post"><button type="submit" name="Rent" style="border: none;text-align: center;cursor: pointer;background-color: rgb(245, 233, 218);color: blue;text-decoration-line: underline;font-size : 16px;}">Related Series</button></form>
                <b>Rent Status: </b><?php if($rentStatus == "Rented") echo "<p style=\"color: green;\">Already Rented</p>";  else echo "<form method=\"post\" style=\"display: inline;\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Rent for: $cost</button></form>" ?><br>
                <form method="post" class="example"><button name="recomend" type="submit" style="width: 100px;" >Recomend</button></form>
                <hr style="width: 500px; text-align:left; margin-left:0"> 
                <form action="/html/tags/html_form_tag_action.cfm" method="post" class="example">
                    <b>Rate: </b><br>
                    <textarea wrap="off" cols="30" rows="5" name="comments" id="comments" placeholder="Add your coment here if you have any..." style="width: 500px; resize: none;"></textarea><br>
                    <label class="rating-label">
                    <input
                        class="rating"
                        max="5"
                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                        step="0.5"
                        style="--value:0"
                        type="range"
                        value="0">
                    </label>
                    <button name="rate" type="submit" style="width: 100px;" >Rate</button>  
                </form>
                <hr style="width: 500px; text-align:left; margin-left:0"> 
                <?php 
                    echo "
                        <b>Yusuf Uyar</b><br>
                        <p>Not gonna lie, they had me in the first half. A well made thriller, always keeping the audience guessing as to what's going to happen. Well made, well acted, and wonderfully dark vibes.</p><br>
                        <b>Rate: 4.0</b><br>
                        <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                    echo "
                        <b>Cagri Durgut</b><br>
                        <b>Rate: 4.0</b><br>
                        <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                    echo "
                        <b>Ali Emre</b><br>
                        <p>I like the bit where he looks out the window and sees the haunted house on the hill</p><br>
                        <b>Rate: 3.5</b><br>
                        <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                    echo "
                        <b>Seckin Satir</b><br>
                        <b>Rate: 4.5</b><br>
                        <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                ?> 
            </div>
        </div>

    </body>  
</html>