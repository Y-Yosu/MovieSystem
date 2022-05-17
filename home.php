<?php
    require_once 'connect.php';
    session_start();
    $error = "";

    $query = "SELECT f_title, f_director, f_year, f_rating, f_genre, f_price, f_id FROM film ";
    $qres = mysqli_query($con,$query);
    if($qres == true) 
        $count = mysqli_num_rows($qres);
    if($qres == true && $count != 0){
        $error = "";
    }
    else{
        $error = "No results from server"; 
    }

    $query = "select * from user natural join has natural join card where user_id = ".$_SESSION['sid'];
    $result = $con->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    $wallet = $row[6];

    //echo "----------MAIN PAGE QUERY: $query";

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
    if(isset($_POST['request'])) {
        $f_title = $_POST['title_r'];
        $f_director = $_POST['director_r'];
        $f_year = $_POST['year_r'];
        $f_genre = $_POST['genre_r'];

        $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'emre_aydogmus' AND TABLE_NAME = 'absent_film'";
        $qres = mysqli_query($con,$query);
        $row = mysqli_fetch_array($qres);
        $next_id = $row['AUTO_INCREMENT'];
        
        $query = "INSERT INTO absent_film ( af_title, af_director, af_year, af_genre) "
        . "VALUES( '$f_title', '$f_director', '$f_year', '$f_genre' )";
        $qres = mysqli_query($con,$query);
        $query = "INSERT INTO request ( user_id, af_id, request_status, request_desc) "
				. "VALUES('".$_SESSION['sid']."', '$next_id', 'Pending', '".$_POST['comments_r']."' )";
        echo "bozuk: $query";
        $qres = mysqli_query($con,$query);
        header("Location: home.php");
    }
    if(isset($_POST['search'])) {
        
        $f_title = $_POST['title'];
        $f_director = $_POST['director'];
        $f_year = $_POST['year'];
        $f_genre = $_POST['genre'];
        $minr = $_POST['minr'];
        $maxr = $_POST['maxr'];
        $minp = $_POST['minC'];
        $maxp = $_POST['maxC'];
        
        $query = "SELECT f_title, f_director, f_year, f_rating, f_genre, f_price, f_id ".
                        "FROM film ".
                        "WHERE ( ( ";
        
        if( $f_title == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_title'";
        $query = $query . " IS NULL) OR (f_title LIKE '%$f_title%') ) AND ( ( ";
        
        if( $f_director == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_director'";
        $query = $query . " IS NULL) OR (f_director LIKE '%$f_director%') ) AND ( ( ";
        
        if( $f_year == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_year'";
        $query = $query . " IS NULL) OR (f_year = '$f_year') ) AND ( ( ";
        
        if( $f_genre == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$f_genre'";
        $query = $query . " IS NULL) OR (f_genre = '%$f_genre%') ) AND ( ( ";
        
        if( $minr == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$minr'";
        $query = $query . " IS NULL) OR (f_rating >= '$minr') ) AND ( ( ";
        
        if( $maxr == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$maxr'";
        $query = $query . " IS NULL) OR (f_rating <= '$maxr') ) AND ( ( ";
        
        if( $minp == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$minp'";
        $query = $query . " IS NULL) OR (f_price >= '$minp') ) AND ( ( ";

        if( $maxp == "" )
            $query = $query . "NULL";
        else
            $query = $query . "'$maxp'";
        $query = $query . " IS NULL) OR (f_price <= '$maxp') ) ";

        //echo " kk: $query !";

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
            <p>Wallet: <?php echo $wallet;?></p>
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
                            if($qres == true){
                                while( $row = mysqli_fetch_array($qres)){
                                    echo "<tr>";
                                    echo "<td>" . $row['f_title'] . "</td>";
                                    echo "<td>" . $row['f_director'] . "</td>";
                                    echo "<td>" . $row['f_genre'] . "</td>";
                                    echo "<td>" . $row['f_year'] . "</td>";
                                    if( is_null( $row['f_rating'] ) )
                                        echo "<td>" . "-" . "</td>";
                                    else
                                        echo "<td>" . $row['f_rating'] . "</td>";
                                    echo "<td>" . $row['f_price'] . "$</td>";
                                    echo "<td style=\"text-align:left;\"><form method=\"post\"><button type=\"submit\" name=\"moviePage\" class=\"rentButton\" value =". $row['f_id'].">Movie Page</button></form></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            }
                        }
                        else {
                            echo "<p style=\"text-align: left; color: red;\">No such film exsists...</p>";
                            echo "<p style=\"text-align: left;\">Can't find what you are looking for? Request a new film here:</p>
                            <form method=\"post\" class=\"example\">
                                <input name=\"title_r\" type=\"text\" size=\"10\" placeholder = \"Title\" required>
                                <input name=\"director_r\" type=\"numerical\" size=\"10\" placeholder = \"Director\" required>
                                <input name=\"genre_r\" type=\"numerical\" size=\"5\" placeholder = \"Genre\" required>
                                <input name=\"year_r\" type=\"numerical\" size=\"2\" placeholder = \"Year\" required><br>
                                <textarea wrap=\"off\" cols=\"30\" rows=\"5\" name=\"comments_r\" id=\"comments\" placeholder=\"Additional Coments...\" style=\"width: 335px; resize: none;\"></textarea><br>
                                <button name=\"request\" type=\"submit\"> Make Request</button>  
                            </form>";
                        }
                    ?>
            </div>
        </div>

    </body>  
</html>