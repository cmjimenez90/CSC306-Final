<?php
    /*
        Author: Carlos Jimenez
        Date: 15 December 2019

        Main entry to the gone boarding store app
        Very basic routing is handled through this page.
        Query params will load the needed page. If query fails default to store page.
    */
    session_start();
    $currentPage = '' ;
    $page = $_GET['page'];
    switch($page) {
        case 'mycart': 
            $currentPage = $page;
            break;
        case 'customerdetails':
            $currentPage = $page;
            break;
        default: 
            $currentPage = 'store';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gone Boarding</title>
    <link type="text/css" rel="stylesheet" href="../includes/css/materialize.css"  media="screen,projection">
    <link type="text/css" rel="stylesheet" href="../includes/css/main.css"  media="screen,projection">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <header>      
    </header>
    <div class="container ">
            <?php require "../pages/" . $currentPage . ".php"; ?>      
    </div>
    <footer>
    </footer>
    <script type="text/javascript" src="../includes/js/materialize.js"></script>
</html>

