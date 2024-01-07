<?php
if (isset($_GET['page'])){
    $page = $_GET['page'];
    switch($page){
        case '':
        case 'home':
            file_exists('pages/home.php') ? include 'pages/home.php' : include "pages/404.php";
            break;
        default:
            include "pages/404.php";
        }
} else {
    include "pages/home.php";
}
?>