<?php
//Computing commission on sales

//INIT
require "app/config.php";
require PATH_LIB . "lib.php";
$libDB = new DB();
session_start();

$rID = $_SESSION('userid');
$oID = 23;
$payment = 1000 ;
$commission = (10*$payment)/100;
$date = date("Y-m-d H:i:s");

$referral = $libDB->fetch(
    "SELECT * from `referral` WHERE `username`=?", [$rID]
);

if(is_array($referral)) {
    $referer = $referral['referer'];
}

$sales = $libDB->exec(
    "INSERT INTO `ref_sales` (`referral_id`, `order_id`, `payment`, `commission`, `date`)", [$referer, $oID, $payment, $commission, $date]
);

echo $sales ? "OK" : $libDB->error;