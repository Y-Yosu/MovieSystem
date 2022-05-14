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
            <p>Wallet: <?php echo $_SESSION['wallet'];?></p>
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
                <h3 style="text-align: left;">Search Films By:</h3>
                <form method="post" class="example">
                    <input name="title" type="text" size="10" placeholder = "Title">
                    <input name="director" type="numerical" size="10" placeholder = "Director">
                    <input name="genre" type="numerical" size="5" placeholder = "Genre">
                    <input name="year" type="numerical" size="2" placeholder = "Year">
                    <input name="minr" type="numerical" size="1" placeholder = "MinR"> 
                    <input name="maxr" type="numerical" size="1" placeholder = "MaxR">
                    <input name="minC" type="numerical" size="1" placeholder = "Min$">
                    <input name="maxC" type="numerical" size="1" placeholder = "Max$">
                    <button name="search" type="submit" style="width:  75px"><i class="fa fa-search"></i></button>  
                </form>
 
                    <?php
                        if($error == "") {
                            echo "<h3 style=\"text-align: left;\">Films:</h3>
                                <table>
                                    <tr>
                                        <th>Title</th>
                                        <th>Director</th>
                                        <th>Genre</th>
                                        <th>Year</th>
                                        <th>Rate</th>
                                        <th>Cost</th>
                                    </tr> ";
                            echo "<tr><td>" . "Number 13" . "</td><td>" . "Alfred Hitchcock" . "</td><td>" . "Dram" . "</td><td>" . "1922" . "</td><td>" . "6.3" . "</td><td>" . "30$" ."</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Movie Page</button></form></td></tr>";
                            echo "<tr><td>" . "The Pleasure Garden" . "</td><td>" . "Alfred Hitchcock" . "</td><td>" . "Dram" . "</td><td>" . "1925" . "</td><td>" . "5.7" . "</td><td>" . "20$" ."</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Movie Page</button></form></td></tr>";
                            echo "<tr><td>" . "The Mountain Eagle" . "</td><td>" . "Alfred Hitchcock" . "</td><td>" . "Dram" . "</td><td>" . "1926" . "</td><td>" . "7.4" . "</td><td>" . "40$" ."</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Movie Page</button></form></td></tr>";
                            echo "<tr><td>" . "The Ring" . "</td><td>" . "Alfred Hitchcock" . "</td><td>" . "Romance" . "</td><td>" . "1927" . "</td><td>" . "7.3" . "</td><td>" . "40$" ."</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Movie Page</button></form></td></tr>";
                            echo "<tr><td>" . "Downhill" . "</td><td>" . "Alfred Hitchcock" . "</td><td>" . "Dram" . "</td><td>" . "1927" . "</td><td>" . "7.8" . "</td><td>" . "45$" ."</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Movie Page</button></form></td></tr>";
                            echo "<tr><td>" . "Psycho" . "</td><td>" . "Alfred Hitchcock" . "</td><td>" . "Horror" . "</td><td>" . "1960" . "</td><td>" . "8.2" . "</td><td>" . "50$" ."</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"Rent\" class=\"rentButton\">Movie Page</button></form></td></tr></table>";
                        }
                        else {
                            echo "<p style=\"text-align: left; color: red;\">No such film exsists...</p>";
                            echo "<p style=\"text-align: left;\">Can't find what you are looking for? Request a new film here:</p>
                            <form method=\"post\" class=\"example\">
                                <input name=\"title\" type=\"text\" size=\"10\" placeholder = \"Title\" required>
                                <input name=\"director\" type=\"numerical\" size=\"10\" placeholder = \"Director\" required>
                                <input name=\"genre\" type=\"numerical\" size=\"5\" placeholder = \"Genre\" required>
                                <input name=\"year\" type=\"numerical\" size=\"2\" placeholder = \"Year\" required><br>
                                <textarea wrap=\"off\" cols=\"30\" rows=\"5\" name=\"comments\" id=\"comments\" placeholder=\"Additional Coments...\" style=\"width: 335px; resize: none;\"></textarea><br>
                                <button name=\"request\" type=\"submit\"> Make Request</button>  
                            </form>";
                        }
                    ?>
            </div>
        </div>

    </body>  
</html>