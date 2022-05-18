<?php
    require_once 'connect.php';
    session_start();
    
    if(is_null($_SESSION['sname'])) {
        header("Location: notlogedin.php");
    }
    
    $error = "";
    
    $query = "SELECT F.f_title, F.f_director, F.f_year, F.f_rating, F.f_genre, R.rent_date, F.f_id FROM film as F, rent as R WHERE R.user_id = '" .$_SESSION['sid']. "' AND R.f_id = F.f_id ORDER BY R.rent_date";
    $qres = mysqli_query($con,$query);
    
    if($qres == true) 
        $count = mysqli_num_rows($qres);
    if($qres == true && $count != 0){
        $error = "";
    }
    else{
        $error = "No results from server"; 
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
    if(isset($_POST['manageFilms'])) {
        header("Location: manageFilms.php");
    }
    if(isset($_POST['manageUsers'])) {
        header("Location: manageUsers.php");
    }
    if(isset($_POST['statistics'])) {
        header("Location: statistics.php");
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
    if(isset($_POST['search'])) {
        
        $f_title = $_POST['title'];
        $f_director = $_POST['director'];
        $f_year = $_POST['year'];
        $f_genre = $_POST['genre'];
        $minr = $_POST['minr'];
        $maxr = $_POST['maxr'];
        
        $query = "SELECT F.f_title, F.f_director, F.f_year, F.f_rating, F.f_genre, R.rent_date, F.f_id ".
                        "FROM film as F, rent as R ".
                        "WHERE R.user_id = '" .$_SESSION['sid']. "' AND R.f_id = F.f_id AND ( ( ";

        if( $f_title == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_title'";
        $query = $query . " IS NULL) OR (F.f_title LIKE '%$f_title%') ) AND ( ( ";
        
        if( $f_director == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_director'";
        $query = $query . " IS NULL) OR (F.f_director LIKE '%$f_director%') ) AND ( ( ";
        
        if( $f_year == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_year'";
        $query = $query . " IS NULL) OR (F.f_year = '$f_year') ) AND ( ( ";
        
        if( $f_genre == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_genre'";
        $query = $query . " IS NULL) OR (F.f_genre LIKE '%$f_genre%') ) AND ( ( ";
        
        if( $minr == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$minr'";
        $query = $query . " IS NULL) OR (F.f_rating >= '$minr') ) AND ( ( ";
        
        if( $maxr == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$maxr'";
        $query = $query . " IS NULL) OR (F.f_rating <= '$maxr') ) ORDER BY R.rent_date";

        //echo "kk: $query !";

        $qres = mysqli_query($con,$query);
        if($qres == true) 
            $count = mysqli_num_rows($qres);
        if($qres == true && $count != 0){
            $error = "";
        }
        else{
            $error = "No results from query"; 
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
                <button type=\"submit\" name=\"manageUsers\" id=\"manageUsers\">Manage Users</button>
                <button type=\"submit\" name=\"statistics\" id=\"statistics\">Statisttics</button>";?>
                <button type="submit" name="logout" id="logout" style="color: red">Log Out</button>
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
                    <button name="search" type="submit" style="width:  75px"><i class="fa fa-search"></i></button>  
                </form>
                    <?php
                        if($error == "") {
                            echo "<h3 style=\"text-align: left;\">Rented Films:</h3>
                                <table>
                                    <tr>
                                        <th>Title</th>
                                        <th>Director</th>
                                        <th>Genre</th>
                                        <th>Year</th>
                                        <th>Rate</th>
                                        <th>Rent Date</th>
                                    </tr> ";
                                    if($qres == true){
                                        while( $row = mysqli_fetch_array($qres)){
                                            echo "<tr>";
                                            echo "<td>" . $row['f_title'] . "</td>";
                                            echo "<td>" . $row['f_director'] . "</td>";
                                            echo "<td>" . $row['f_genre'] . "</td>";
                                            echo "<td>" . $row['f_year'] . "</td>";
                                            echo "<td>" . $row['f_rating'] . "</td>";
                                            echo "<td>" . $row['rent_date'] . "</td>";
                                            echo "<td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"moviePage\" class=\"rentButton\" value =". $row['f_id'].">Movie Page</button></form></td>";
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                    }
                        }
                        else if($error == "No results from query"){
                            echo "<p style=\"text-align: left; color: red;\">There are no rented films with such criteria...</p>";
                        }
                        else {
                            echo "<p style=\"text-align: left; color: red;\">No films found in history...</p>";
                        }
                    ?>
                </table>
            </div>
        </div>

    </body>  
</html>