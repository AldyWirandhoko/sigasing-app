<?php
if (isset($_GET['page'])){
    $page = $_GET['page'];
    switch($page){
        case '':
        case 'home':
            file_exists('pages/home.php') ? include 'pages/home.php' : include "pages/404.php";
            break;
        //data master lokasi
        case 'lokasiread':
            file_exists('pages/admin/lokasiread.php') ? include 'pages/admin/lokasiread.php' : include "pages/404.php";
            break;
        case 'lokasicreate':
            file_exists('pages/admin/lokasicreate.php') ? include 'pages/admin/lokasicreate.php' : include "pages/404.php";
            break;
        case 'lokasiupdate':
            file_exists('pages/admin/lokasiupdate.php') ? include 'pages/admin/lokasiupdate.php' : include "pages/404.php";
            break;
        case 'lokasidelete':
            file_exists('pages/admin/lokasidelete.php') ? include 'pages/admin/lokasidelete.php' : include "pages/404.php";
            break;
        //data master Jabatan
        case 'jabatanread':
            file_exists('pages/admin/jabatanread.php') ? include 'pages/admin/jabatanread.php' : include "pages/404.php";
            break;
        case 'jabatancreate':
            file_exists('pages/admin/jabatancreate.php') ? include 'pages/admin/jabatancreate.php' : include "pages/404.php";
            break;
        case 'jabatanupdate':
            file_exists('pages/admin/jabatanupdate.php') ? include 'pages/admin/jabatanupdate.php' : include "pages/404.php";
            break;
        case 'jabatandelete':
            file_exists('pages/admin/jabatandelete.php') ? include 'pages/admin/jabatandelete.php' : include "pages/404.php";
            break;
        //data master bagian
        case 'bagianread':
            file_exists('pages/admin/bagianread.php') ? include 'pages/admin/bagianread.php' : include "pages/404.php";
            break;
        case 'bagiancreate':
            file_exists('pages/admin/bagiancreate.php') ? include 'pages/admin/bagiancreate.php' : include "pages/404.php";
            break;
        case 'bagianupdate':
            file_exists('pages/admin/bagianupdate.php') ? include 'pages/admin/bagianupdate.php' : include "pages/404.php";
            break;
        case 'bagiandelete':
            file_exists('pages/admin/bagiandelete.php') ? include 'pages/admin/bagiandelete.php' : include "pages/404.php";
            break;
        //data master karyawan
        case 'karyawanread':
            file_exists('pages/admin/karyawanread.php') ? include 'pages/admin/karyawanread.php' : include "pages/404.php";
            break;
        case 'karyawancreate':
            file_exists('pages/admin/karyawancreate.php') ? include 'pages/admin/karyawancreate.php' : include "pages/404.php";
            break;
        case 'karyawanupdate':
            file_exists('pages/admin/karyawanupdate.php') ? include 'pages/admin/karyawanupdate.php' : include "pages/404.php";
            break;
        default:
            include "pages/404.php";
        }
} else {
    include "pages/home.php";
}
?>