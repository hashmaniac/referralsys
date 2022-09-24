<?php
// 1. Create referral account

//INIT
require "app/config.php";
require PATH_LIB . "lib.php";
$libDB = new DB();

//Create new Account
$pass = $libDB->exec(
    "INSERT INTO 'users' ('username', 'email', 'password') VALUES (?, ?, ?)", ["johndoe", "johndoe@example.com", "12345678"]
);
echo $pass ? "OK" : $libDB->error;

//If 'ref id' exists, insert into referral table the ref id and username of acoount being registered
if(isset($_GET('ref'))) {
    $referer = $_GET('ref');
    $from = $libDB->exec(
        "INSERT INTO 'referral' ('username', 'referer') VALUES (?, ?)", ["johndoe", $referer]
    );
}

