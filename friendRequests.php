<?php
    require_once 'connect.php';
    session_start();
    
    if(is_null($_SESSION['sname'])) {
        header("Location: notlogedin.php");
    }

    $error = "found";

    $query = "SELECT C2.user_id, C2.user_name, C2.user_surname, C2.user_mail FROM add_friend as C1, user as C2 WHERE C1.added_id = '".$_SESSION["sid"]."' AND C1.adder_id = C2.user_id AND request_status = 'Pending'";
    $result = mysqli_query($con, $query);

    if(isset($_POST['search'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $mail = $_POST['email'];

        $query = "SELECT C2.user_id, C2.user_name, C2.user_surname, C2.user_mail FROM add_friend as C1, user as C2 WHERE (C1.added_id = '".$_SESSION["sid"]."' AND C1.adder_id = C2.user_id AND request_status = 'Pending') AND ( ( ";
        if($name == "") $query = $query . "NULL"; else $query = $query . "'$name'"; 
        $query = $query . " IS NULL) OR (C2.user_name LIKE '%$name%') ) AND ( ( ";
        if($surname == "") $query = $query . "NULL"; else $query = $query . "'$surname'"; 
        $query = $query . " IS NULL) OR (C2.user_surname LIKE '%$surname%') ) AND ( ( ";
        if($mail == "") $query = $query . "NULL"; else $query = $query . "'$mail'"; 
        $query = $query . " IS NULL) OR (C2.user_mail LIKE '%$mail%') )";
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
    if(isset($_POST['statistics'])) {
        header("Location: statistics.php");
    }
    if(isset($_POST['Accept'])) {
        $query2 = "UPDATE add_friend, user SET add_friend.request_status = 'Accepted' WHERE add_friend.added_id = '".$_SESSION["sid"]."' AND add_friend.adder_id = '".$_POST['Accept']."'";
        $result2 = mysqli_query($con, $query2);

        $query = "SELECT C2.user_id, C2.user_name, C2.user_surname, C2.user_mail FROM add_friend as C1, user as C2 WHERE C1.added_id = '".$_SESSION["sid"]."' AND C1.adder_id = C2.user_id AND request_status = 'Pending'";
        $result = mysqli_query($con, $query);
        header("Location: friendRequests.php");
    }
    if(isset($_POST['Decline'])) {
        $query2 = "DELETE FROM add_friend WHERE add_friend.added_id = '".$_SESSION["sid"]."' AND add_friend.adder_id = '".$_POST['Decline']."'";
        $result2 = mysqli_query($con, $query2);

        $query = "SELECT C2.user_id, C2.user_name, C2.user_surname, C2.user_mail FROM add_friend as C1, user as C2 WHERE C1.added_id = '".$_SESSION["sid"]."' AND C1.adder_id = C2.user_id AND request_status = 'Pending'";
        $result = mysqli_query($con, $query);
        header("Location: friendRequests.php");
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
                   color: green;
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
            <div style="text-align:center;"><p>Wallet: <?php echo "$".$_SESSION['wallet'];?></p></div>
            <form method="post">
            <div class="btn-group">
                <button type="submit" name="home" id="home">Home Page</button>
                <button type="submit" name="rentedMovies" id="rentedMovies">Rented Movies</button>
                <button type="submit" name="rentHistory" id="rentHistory">Rent History</button>
                <button type="submit" name="friends" id="friends">Friends</button>
                <?php if($_SESSION['admin'] == "admin") echo "<button type=\"submit\" name=\"manageFilms\" id=\"manageFilms\">Manage Films</button>
                <button type=\"submit\" name=\"manageUsers\" id=\"manageUsers\">Manage Users</button>
                <button type=\"submit\" name=\"statistics\" id=\"statistics\">Statisttics</button>";?>
                <button type="submit" name="logout" id="logout" style="color: red">Log Out</button>
            </div></form>
        </div>

        <div class="right" >
            <div style="padding:0 10px;">
                <h3 style="text-align: left;">Search Requests:</h3>
                <form method="post" class="example">
                    <input name="name" type="text" size="5" placeholder = "Name">
                    <input name="surname" type="numerical" size="5" placeholder = "Surname">
                    <input name="email" type="numerical" size="15" placeholder = "Email">
                    <button name="search" type="submit" style="width:  75px"><i class="fa fa-search"></i></button>  
                </form>
                <?php
                        if($error == "found") {
                            echo "<h3 style=\"text-align: left;\">Requests:</h3>
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                    </tr> ";
                            while($row = mysqli_fetch_array($result)) {
                                echo "<tr><td>" . $row['user_name'] . "</td><td>" . $row['user_surname']  . "</td><td>" . $row['user_mail'] . "</td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" value=".$row['user_id']." name=\"Accept\" class=\"rentButton\">Accept Request</button></form></td><td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" value=".$row['user_id']." name=\"Decline\" class=\"rentButton\" style=\"color: red;\">Decline Request</button></form></td></tr>";
                            }        
                            echo "</table><br><br>";        
                        }
                        else if ($error == "notFound") {
                            echo "<p style=\"text-align: left; color: red;\">No such user exsists...</p>";
                        }
                    ?> 
            </div>
        </div>

    </body>  
</html>