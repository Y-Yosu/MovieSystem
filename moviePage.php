<?php
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
?>
<?php

    session_start();
    require_once 'connect.php';
    $sid = $_SESSION['sid'];
    if(array_key_exists("goToMovie", $_POST))
        $_SESSION['goToMovie'] = $_POST["goToMovie"];
    $movieId = $_SESSION['goToMovie'];
    
    $query = "select * from user natural join has natural join card where user_id = ".$_SESSION['sid'];
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    $wallet = $row[6];
    
    $query = "select * from film where f_id = '$movieId';";
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    
    
    $error = "";
    
    $title = $row[1];
    $director = $row[2];
    $year = $row[3];
    $rate = $row[4];
    $genre = $row[5];
    $cost = "$row[6]$";
    $description = $row[7];
    $userrated = false;
    $userreviewed = false;
    $rentStatus = false;
    $isSeries = false;
    
    $query = "select * from part_of where f_id = '$movieId';";
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    if($row){
        $isSeries = true;
        $seriesId = $row[1];
    }

    $query = "select * from rent where f_id = '$movieId' AND user_id = '$sid';";
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);

    if($row){
        $rentStatus = $row[3];
    }
    
    $query = "select * from rate where f_id = '$movieId' AND user_id = '$sid';";
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    if($row){
        $userrated = true;
        $oldRating = $row[3];
    }
    
    $query = "select * from review where f_id = '$movieId' AND user_id = '$sid';";
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    if($row){
        $userreviewed = true;
        $oldReview = $row[3];
        debug_to_console($oldReview);
    }

    if($rentStatus)
        debug_to_console($rentStatus);
    

    if(isset($_POST['rate'])) {

        debug_to_console('comments ' . $_POST['comments']);
        debug_to_console('rating ' . $_POST['rating']);

        if($userrated){
            $query = "update rate Set r_rating = " . $_POST['rating'] . ",r_date = now() where f_id = '$movieId' AND user_id = '$sid';";
            $result = $con->query($query);}
        else{
            $query = " insert into rate Values( ". $sid .",". $movieId .",now()," . $_POST['rating'] . " );";
            $result = $con->query($query);
        }
        if($userreviewed){
            $query = "update review Set r_text = '" . $_POST['comments'] . "' where f_id = '$movieId' AND user_id = '$sid';";
            $result = $con->query($query);}
        else{
            $query = " insert into review Values( ". $sid .",". $movieId .",now(),'" . $_POST['comments'] . "' );";
            // debug_to_console($query);
            $result = $con->query($query);
        }
    }

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
    if(isset($_POST['Rent'])) {
        if($rentStatus == "Ongoing"){

        }
        else {
            $query = "select * from user natural join has natural join card where user_id = '$sid'";
            $result = $con->query($query);
            $row = $result->fetch_array(MYSQLI_NUM);
            debug_to_console($row);
            $wallet = $row[6];
            $cardid = $row[0];
            // debug_to_console(($wallet-$cost));
            if( floatval($wallet) >= floatval($cost) ){
                if($rentStatus == "Expired"){
                    $query = "update rent Set rent_date = now(), rent_status = 'Ongoing' where f_id = '$movieId' AND user_id = '$sid';";
                    $result = $con->query($query);
                }
                else{
                    $query = "insert into rent Values($sid,'$movieId',now(),'Ongoing');";
                    $result = $con->query($query);
                }
                $query = "update card Set balance = " . ($wallet-$cost) . " where card_id = '$cardid';";
                $result = $con->query($query);
                header("Refresh:0");
            }
        }
    }

    
    // if($userrated)
    //     debug_to_console($oldRating);

    // $query = "select * from review where f_id = '$movieId' AND user_id = '$sid';";
    // $result = $con->query($query);
    // $row = $result->fetch_array(MYSQLI_NUM);
    // if($row){
    //     $userreviewed = true;
    //     $oldReview = $row[3];
    // }

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
            <div style="text-align:center;  margin-bottom: 18px;"><p>Wallet: <?php echo $wallet;?></p></div>
            <form method="post">
            <div class="btn-group">
                <button type="submit" name="home" id="home">Home Page</button>
                <button type="submit" name="rentedMovies" id="rentedMovies">Rented Movies</button>
                <button type="submit" name="rentHistory" id="rentHistory">Rent History</button>
                <button type="submit" name="friends" id="friends">Friends</button>
                <?php if($_SESSION['admin'] == "admin") echo "<button type=\"submit\" name=\"manageFilms\" id=\"manageFilms\">Manage Films</button>
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
                <?php
                    if($isSeries){
                        $_SESSION['series'] = $seriesId;
                        echo "<form action=\"series.php\" method=\"post\">
                        <button type=\"submit\" style=\"border: none;text-align: center;cursor: pointer;background-color: rgb(245, 233, 218);color: blue;text-decoration-line: underline;font-size : 16px;}\">Related Series</button>
                        </form>";
                    }
                ?>
                
                <?php
                    if($rentStatus == "Ongoing") echo "<p style=\"color: green;\">Already Rented</p>";
                    else echo "<form method=\"post\" style=\"display: inline;\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Rent for: $cost</button></form>" 
                ?><br><br>
                <form method="post" action="recommend.php" class="example"><button name="recommend" type="submit" style="width: 100px;" >Recommend</button></form>
                <hr style="width: 500px; text-align:left; margin-left:0"> 
                <?php
                if($userrated ) 
                echo "";
                if($rentStatus == "Ongoing" || $rentStatus == "Expired" ) 
                echo " <form method=\"post\" class=\"example\">
                    <b>Rate: </b><br>
                    <textarea wrap=\"off\" cols=\"30\" rows=\"5\" name=\"comments\" id=\"comments\" placeholder=\"Add your comment here if you have any...\" style=\"width: 500px; resize: none;\"></textarea><br>
                    <label class=\"rating-label\">
                    <input
                        class=\"rating\"
                        id=\"ratingslider\"
                        name=\"rating\"
                        max=\"5\"
                       
                        step=\"0.5\"
                        style=\"--value:0\"
                        type=\"range\"
                        value=\"0\">
                    </label>
                    <button id=\"submitbutton\" name=\"rate\" style=\"width: 100px;\" >Rate</button>  
                </form>";
                
                else echo "<p style=\"color: red;\">You are not allowed to rate this movie since you don't own it.</p>";
                ?>
                
               
                <hr style="width: 500px; text-align:left; margin-left:0">

                 
                <?php 
                    
                    $query = "select * from rate Natural Join user where f_id = '$movieId';";
                    $result = $con->query($query);
                    $row = $result->fetch_array(MYSQLI_NUM);
                    while($row){
                        $query2 = "select * from review where f_id = '$movieId' AND user_id = '$row[0]';";
                        $result2 = $con->query($query2);
                        $row2 = $result2->fetch_array(MYSQLI_NUM);
                        if($row[0] == $sid)
                            echo "<b style=\"color:blue;\">You</b><br>";
                        else
                            echo "<b>$row[4] $row[5]</b><br>";
                        if($row2)
                            echo "<p>$row2[3].</p><br>";
                        echo "<b>Rate: $row[3]</b><br>";
                        echo "<hr style=\"width: 500px; text-align:left; margin-left:0\">";
                        // if($row2 != "")
                        //     debug_to_console("person: " . $row[4] . " rate: " . $row[3] . " review: " . $row2[3]. " date: " . $row[2]);
                        // else
                        //     debug_to_console("person: " . $row[4] . " rate: " . $row[3] . " date: " . $row[2]);
                        $row = $result->fetch_array(MYSQLI_NUM);
                    }
                ?> 
            </div>
        </div>

    </body>
    <script>
        let a = document.getElementById('ratingslider')
        a.oninput = ()=>{a.style.setProperty('--value', `${a.valueAsNumber}`);}
        let button = document.getElementById('submitbutton')
    </script>
</html>