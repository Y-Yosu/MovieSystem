<?php
    require_once 'connect.php';
    session_start();
    $error = "";
    $admin = "admin";
    
    $query = "SELECT U.user_name, U.user_surname, A.af_title, A.af_director, A.af_genre, A.af_year, R.request_desc, A.af_id FROM user as U, absent_film as A, request as R WHERE A.af_id = R.af_id AND R.user_id = U.user_id";
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
    if(isset($_POST['requestNew'])) {
        header("Location: requestNewFilm.php");
    }
    if(isset($_POST['manageFilms'])) {
        header("Location: manageFilms.php");
    }
    if(isset($_POST['manageUsers'])) {
        header("Location: manageUsers.php");
    }
    if(isset($_POST['addFilm'])) { 
        
        $query2 = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'emre_aydogmus' AND TABLE_NAME = 'film'";
        $qres2 = mysqli_query($con,$query2);
        $row2 = mysqli_fetch_array($qres2);
        $next_id = $row2['AUTO_INCREMENT'];
        
        $query2 = "INSERT INTO film ( f_title, f_director, f_year, f_rating, f_genre, f_price, f_desc) "
        . "VALUES( '".$_POST['title']."', '".$_POST['director']."', '".$_POST['year']."', NULL, '".$_POST['genre']."', '".$_POST['cost']."', '".$_POST['description']."' )";
        $qres2 = mysqli_query($con,$query2);
        
        $query2 = "INSERT INTO part_of ( f_id, series_name, order_no ) "
        . "VALUES( '".$next_id."', '".$_POST['series']."', NULL )";
        $qres2 = mysqli_query($con,$query2);
        header("Location: manageFilms.php");
    }
    if(isset($_POST['deleteRequest'])) {

        $query3 = "DELETE FROM absent_film WHERE af_id = ".$_POST['deleteRequest']."";
        $qres3 = mysqli_query($con,$query3);

        header("Location: manageFilms.php");
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
                    <input name="title" type="text" size="10" placeholder = "Title" required>
                    <input name="director" type="numerical" size="10" placeholder = "Director" required>
                    <input name="genre" type="numerical" size="5" placeholder = "Genre" required>
                    <input name="year" type="numerical" size="2" placeholder = "Year" required>
                    <input name="cost" type="numerical" size="1" placeholder = "Cost" required>
                    <input name="series" type="text" size="10" placeholder = "Series" required><br>
                    <textarea wrap="off" cols="30" rows="5" name="description" id="description" placeholder="Description" style="width: 495px; resize: none;" required></textarea><br>
                    <button name="addFilm" type="submit" style="width:  75px">Add</button>  
                </form>
                <hr style="width: 500px; text-align:left; margin-left:0"> 
                <h3 style="text-align: left;">Requests</h3>
                    <?php
                        if($error == "") {

                            if($qres == true){
                                while( $row = mysqli_fetch_array($qres)){
                                    echo "
                                    <b>" . $row['user_name'] . " " .$row['user_surname']. "</b><br>
                                    <b>Title: </b><p>".$row['af_title']."</p><b>    Director: </b><p>".$row['af_director']."</p><b>    Genre: </b><p>".$row['af_genre']."</p><b>    Year: </b><p>".$row['af_year']."<p><br>";
                                    //<b>Coment: </b><p>Realy good film. Please add</p><br>
                                    if( is_null($row['request_desc']) OR $row['request_desc'] == "" )
                                        echo "<p>User added no comments.</p><br>";
                                    else
                                        echo "<b>Comment: </b><p>".$row['request_desc']."</p><br>";
                                    echo "
                                    <form method=\"post\"><button type=\"submit\" name=\"deleteRequest\" class=\"rentButton\" value = ".$row['af_id'].">Discard Request</button></form>
                                    <hr style=\"width: 500px; text-align:left; margin-left:0\">";
                                    /*
                                    if( is_null( $row['f_rating'] ) )
                                        echo "<td>" . "-" . "</td>";
                                    else
                                        echo "<td>" . $row['f_rating'] . "</td>";
                                        */
                                    
                                }
                                echo "</table>";
                            }

                        }
                        else {
                            echo "<p style=\"text-align: left; color: red;\">There are no requests</p>";
                        }
                    ?>
            </div>
        </div>

    </body>  
</html>