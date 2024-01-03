<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

if (isset($_COOKIE['remember_me'])) {
    $token = checkString($_COOKIE['remember_me']);
    try {
        $result = JWT::decode($token, new Key(base64_encode($_ENV["APP_KEY"]), 'HS256'));
        $_SESSION['users'] = $result->username;
    } catch (\Throwable $th) {
        setcookie('remember_me', '', time() - 3600, '/');
        session_destroy();
        return redirect("/auth/login");
    }
}
