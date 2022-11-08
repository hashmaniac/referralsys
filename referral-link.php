<?php
// Generating Referral links

//INIT
require "app/config.php";
require PATH_LIB . "lib.php";
$libDB = new DB();
session_start();

$url = "http://localhost/referalsys/create-account.php";

//first attach a session when login is a success on your login logic
// e.g $_SESSION['userid'] = $username

if(isset($_SESSION['userid'])) {
    echo $url . "?ref=" . $_SESSION('userid');
}