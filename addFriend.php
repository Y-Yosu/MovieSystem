<?php
    require_once 'connect.php';
    session_start();
    if(is_null($_SESSION['sname'])) {
        header("Location: notlogedin.php");
    }
    
    
    $error = "found";

    $query = "SELECT DISTINCT U.user_id, U.user_name, U.user_surname, U.user_mail FROM user as U, add_friend as A WHERE U.user_id <> '".$_SESSION["sid"]."' AND U.user_id NOT IN ( SELECT adder_id FROM add_friend WHERE added_id = '".$_SESSION["sid"]."' AND (request_status = 'Accepted' or request_status = 'Pending')) AND U.user_id NOT IN( SELECT added_id FROM add_friend WHERE adder_id = '".$_SESSION["sid"]."' AND (request_status = 'Accepted' OR request_status = 'Pending') )";
    $result = mysqli_query($con, $query);

    if(isset($_POST['search'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $mail = $_POST['email'];

        $query = "SELECT DISTINCT U.user_id, U.user_name, U.user_surname, U.user_mail FROM user as U, add_friend as A WHERE (U.user_id <> '".$_SESSION["sid"]."' AND U.user_id NOT IN ( SELECT adder_id FROM add_friend WHERE added_id = '".$_SESSION["sid"]."' AND (request_status = 'Accepted' or request_status = 'Pending')) AND U.user_id NOT IN( SELECT added_id FROM add_friend WHERE adder_id = '".$_SESSION["sid"]."' AND (request_status = 'Accepted' OR request_status = 'Pending') )) AND ( ( ";
        if($name == "") $query = $query . "NULL"; else $query = $query . "'$name'"; 
        $query = $query . " IS NULL) OR (U.user_name LIKE '%$name%') ) AND ( ( ";
        if($surname == "") $query = $query . "NULL"; else $query = $query . "'$surname'"; 
        $query = $query . " IS NULL) OR (U.user_surname LIKE '%$surname%') ) AND ( ( ";
        if($mail == "") $query = $query . "NULL"; else $query = $query . "'$mail'"; 
        $query = $query . " IS NULL) OR (U.user_mail LIKE '%$mail%') )";
        $result = mysqli_query($con, $query);
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
    if(isset($_POST['SendRequest'])) {
        $query2 = "INSERT INTO add_friend (adder_id, added_id, request_status) VALUES ('".$_SESSION["sid"]."', '".$_POST['SendRequest']."', 'Pending' )";
        $result2 = mysqli_query($con, $query2);

        $query = "SELECT DISTINCT U.user_id, U.user_name, U.user_surname, U.user_mail FROM user as U, add_friend as A WHERE U.user_id <> '".$_SESSION["sid"]."' AND U.user_id NOT IN ( SELECT adder_id FROM add_friend WHERE added_id = '".$_SESSION["sid"]."' AND (request_status = 'Accepted' or request_status = 'Pending')) AND U.user_id NOT IN( SELECT added_id FROM add_friend WHERE adder_id = '".$_SESSION["sid"]."' AND (request_status = 'Accepted' OR request_status = 'Pending') )";
        $result = mysqli_query($con, $query);
        header("Location: addFriend.php");
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
                   color: blue;
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
            <div style="text-align:center; margin-bottom: 18px;"><p>Wallet: <?php echo $_SESSION['wallet'];?></p></div>
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
                <h3 style="text-align: left;">Add Friends:</h3>
                <form method="post" class="example">
                    <input name="name" type="text" size="5" placeholder = "Name">
                    <input name="surname" type="numerical" size="5" placeholder = "Surname">
                    <input name="email" type="numerical" size="15" placeholder = "Email">
                    <button name="search" type="submit" style="width:  75px"><i class="fa fa-search"></i></button>  
                </form>
                <?php
                        if($result == true) 
                            $count = mysqli_num_rows($result);
                        if($result == true && $count != 0) {
                            echo "<h3 style=\"text-align: left;\">Search Resault:</h3>
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                    </tr> ";
                            while($row = mysqli_fetch_array($result)) {
                                echo "<tr><td>" . $row['user_name'] . "</td><td>" . $row['user_surname'] . "</td><td>" . $row['user_mail'] . "</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" value=".$row['user_id']." name=\"SendRequest\" class=\"rentButton\">Send Request</button></form></td></tr>";
                            }        
                            echo "</table>";
                        }
                        else
                            echo "<p style=\"text-align: left; color: red;\">No such user exsists...</p>";
                    ?> 
            </div>
        </div>

    </body>  
</html>