<?php
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
include_once(__DIR__ . '/../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
require_once(__DIR__ . "/ConnectionDB.php");
require_once(__DIR__ . "/AppQuery.php");
require_once(__DIR__ . "/Function.php");

if ($_ENV["APP_DEBUG"] == "true") {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
