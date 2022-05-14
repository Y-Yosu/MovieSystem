<?php
    session_start();
    $error = "";
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
        <form action="/html/tags/html_form_tag_action.cfm" method="post" class="example">
            <fieldset>
                <legend style="text-align: center;">Select Friends to recomend</legend>
                <input type="radio" name="f1" id="track" value="track" /><label for="track">Yusuf Uyar</label><br/>
                <input type="radio" name="f2" id="event" value="event"  /><label for="event">Ali Emre</label><br/>
                <input type="radio" name="f3" id="message" value="message" /><label for="message">Cagri Durgut</label><br/>
                <input type="radio" name="f3" id="message" value="message" /><label for="message">Seckin Satir</label><br/>
                <div style="text-align: center;"><button name="recomend" type="submit" style="width: 100px;" >Recomend</button></div>
            </fieldset>
             
        </form>   
    </body>  
</html>