<?php
    require_once 'connect.php';
    session_start();
    
    if(is_null($_SESSION['sname'])) {
        header("Location: notlogedin.php");
    }
    
    $error = "";

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
    if(isset($_POST['moviePage'])) {
        $_SESSION['goToMovie'] = $_POST['moviePage']; 
        header("Location: moviePage.php");
    }
    if(isset($_POST['logout'])){
        if(session_destroy()){
            header("location: index.php");
        }
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
    p {text-align: center;}
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
                   color: blue;
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
            <p>Wallet: <?php echo "$".$_SESSION['wallet'];?></p>
            <form method="post">
            <div class="btn-group">
                <button type="submit" name="home" id="home">Home Page</button>
                <button type="submit" name="rentedMovies" id="rentedMovies">Rented Movies</button>
                <button type="submit" name="rentHistory" id="rentHistory">Rent History</button>
                <button type="submit" name="friends" id="friends">Friends</button>
                <?php if($_SESSION['admin'] == "admin") echo "<button type=\"submit\" name=\"manageFilms\" id=\"manageFilms\">Manage Films</button>
                <button type=\"submit\" name=\"manageUsers\" id=\"manageUsers\">Manage Users</button>";?>
                <button type="submit" name="logout" id="logout" style="color: red">Log Out</button>
            </div></form>
        </div>

        <div class="right" >
            <div style="padding:0 10px;">
                <h3 style="text-align: left;">Recomended Films from Friends:</h3>
                    <?php
                        $query = "SELECT C1.f_id, C1.f_title, C1.f_director, C1.f_genre, C1.f_year, C1.f_rating, C1.f_price FROM film as C1, recommend as C2 WHERE C2.receiver_id = '".$_SESSION["sid"]."' AND C1.f_id = C2.f_id";
                        
                        $result = mysqli_query($con, $query);
                        if($result == true) 
                            $count = mysqli_num_rows($result);
                        if($result == true && $count != 0) {
                            echo "
                                <table>
                                    <tr>
                                        <th>Title</th>
                                        <th>Director</th>
                                        <th>Genre</th>
                                        <th>Year</th>
                                        <th>Rate</th>
                                        <th>Cost</th>
                                    </tr> ";
                            while($row = mysqli_fetch_array($result)) {
                                        echo "<tr><td>" . $row['f_title'] . "</td><td>" . $row['f_director'] . "</td><td>" . $row['f_genre'] . "</td><td>" . $row['f_year'] . "</td><td>" . $row['f_rating'] . "</td><td>" . $row['f_price'] ."$</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" value=".$row['f_id']." name=\"moviePage\" class=\"rentButton\">Movie Page</button></form></td></tr>";
                            }        
                            
                            echo "</table>";
                        }
                        else {
                            echo "<p style=\"text-align: left; color: red;\">No recomendations from friends</p>";;
                        }
                    ?>
            </div>
        </div>

    </body>  
</html>