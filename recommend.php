<?php
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
?>
<?php
    require_once 'connect.php';
    session_start();
    $error = "";
    $sid = $_SESSION['sid'];
    $movieId = $_SESSION['goToMovie'];
    
    if(isset($_POST['recomend'])) {
        $toFriend = $_POST['f1'];
        $query = "INSERT INTO recommend (recommender_id, receiver_id, f_id) VALUES ('".$sid."', '".$toFriend."', '".$movieId."' )";
        $result = $con->query($query);
        
        header("Location: home.php");
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
    body {
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
        <?php
            $query = "SELECT U.user_id, U.user_name, U.user_mail, U.user_surname FROM user as U, add_friend as A WHERE ( A.adder_id = '".$_SESSION['sid']."' AND U.user_id = A.added_id AND A.request_status = 'Accepted' AND NOT EXISTS ( SELECT * FROM recommend as R WHERE R.receiver_id = U.user_id AND R.f_id = '".$_SESSION['goToMovie']."' ) )OR ( A.added_id = '".$_SESSION['sid']."' AND U.user_id = A.adder_id AND A.request_status = 'Accepted' AND NOT EXISTS ( SELECT * FROM recommend as R WHERE R.receiver_id = U.user_id AND R.f_id = '".$_SESSION['goToMovie']."' ) )";
            $result = mysqli_query($con, $query);
            if($result == true) 
                $count = mysqli_num_rows($result);
            if($result == true && $count != 0){
                echo "
                <form method=\"post\" class=\"example\">
                    <fieldset>
                        <legend style=\"text-align: center;\">Select Friends to recomend</legend>
                ";

                while($row = mysqli_fetch_array($result)) {
                    echo "
                    <input type=\"radio\" name=\"f1\" id=\"track\" value=\"" . $row['user_id'] . "\" /><label for=\"track\">" . $row['user_name'] . " " . $row['user_surname'] . " " . $row['user_mail'] . "</label><br/>";
                }
                echo "
                    <div style=\"text-align: center;\"><button name=\"recomend\" type=\"submit\" style=\"width: 100px;\" >Recommend</button></div>
                </fieldset>
                ";
            }
            else {
                echo "<p style=\"text-align: left; color: red;\">You don't have any friends that you haven't recommend this movie curently...</p><br><a href=\"home.php\">Return Home</a>";
            }
            
        ?>             
        </form>   
    </body>  
</html>