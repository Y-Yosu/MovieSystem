<?php
    require_once 'connect.php';
    session_start();
    
    $query1 = "SELECT sum(F.f_price) as weeklyrevenue FROM film as F, rent as R WHERE DATEDIFF( NOW(), R.rent_date ) <= 7 AND F.f_id = R.f_id";
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_array($result1);
    $q1 = number_format($row1[0], 2);

    $query2 = "SELECT sum(F.f_price) as monthlyrevenue FROM film as F, rent as R  WHERE DATEDIFF( NOW(), R.rent_date ) <= 30 AND F.f_id = R.f_id";
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_array($result2);
    $q2 = number_format($row2[0], 2);

    $query3 = "SELECT count(*) as totalNewCustomersWeekly FROM customer WHERE DATEDIFF( NOW(), join_date ) <= 7";
    $result3 = mysqli_query($con, $query3);
    $row3 = mysqli_fetch_array($result3);
    $q3 = $row3[0];

    $query4 = "SELECT count(*) as totalNewCustomersMonthly FROM customer WHERE DATEDIFF( NOW(), join_date ) <= 30";
    $result4 = mysqli_query($con, $query4);
    $row4 = mysqli_fetch_array($result4);
    $q4 = $row4[0];

    $query5 = "SELECT R.rent_date, sum(F.f_price) as monthlyrevenue FROM film as F, rent as R WHERE F.f_id = R.f_id GROUP BY R.rent_date ORDER BY R.rent_date LIMIT 50";
    $result5 = mysqli_query($con, $query5);
    
    if(is_null($_SESSION['sname'])) {
        header("Location: notlogedin.php");
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
                   text-decoration-line: underline;
                   font-size : 16px;}
    table {border-collapse: collapse;
        margin-left: auto;
         margin-right: auto;}
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
            <div style="text-align:center;  margin-bottom: 18px;"><p>Wallet: <?php echo "$".$_SESSION['wallet'];?></p></div>
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
                <h2 style="text-align: center;">Statistics</h2>
                
                <h3>Weekly Revenue</h3>  
                <div style="text-align: center;"><p style="color: green; text-align: center;" ><?php echo "$".$q1; ?></p></div>
                <hr style="width: 600px; margin:auto;margin-top: 20px;"> 
                <h3>Monthly Revenue</h3>  
                <div style="text-align: center;"><p style="color: green; text-align: center;" ><?php echo "$".$q2; ?></p></div>
                <hr style="width: 600px; margin:auto; margin-top: 20px;">
                <h3>Weekly New Customers</h3>  
                <div style="text-align: center;"><p style="color: green; text-align: center;" ><?php echo $q3." new customer"; ?></p></div>
                <hr style="width: 600px; margin:auto;margin-top: 20px;">
                <h3>Monthly New Customers</h3>  
                <div style="text-align: center;"><p style="color: green; text-align: center;" ><?php echo $q4." new customer people"; ?></p></div>
                <hr style="width: 600px; margin:auto;margin-top: 20px;">
                <?php
                    echo "<h3 style=\"text-align: center;\">Daily Revenue</h3>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Revenue</th>
                        </tr> ";
                    if($result5 == true){
                        while( $row5 = mysqli_fetch_array($result5)){
                            echo "<tr>";
                            echo "<td>" . $row5['rent_date'] . "</td>";
                            echo "<td style=\"color: green;\">" . "$".number_format($row5['monthlyrevenue'], 2) . "</td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table><br><br>";
                    ?>                
            </div>
        </div>

    </body>  
</html>