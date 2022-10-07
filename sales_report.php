<?php
//Generate report on referral sales

//INIT
require "app/config.php";
require PATH_LIB . "lib.php";
$libDB = new DB();
session_start();

//fetch report
$rID = 1;
$start = date("Y-m-01 00:00:00");
$end = date("Y-m-t 23:59:59");
$sales = $libDB->fetchAll(
    "SELECT * FROM `ref_sales` WHERE `referral_id`=? AND `date` BETWEEN ? AND ?", [$rID, $start, $end], "order_id"
);
print_r($sales);