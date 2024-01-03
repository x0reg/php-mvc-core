<?php
require_once(__DIR__ . "/../config/Init.php");
require_once(__DIR__ . "/Routers.php");
require_once(__DIR__ . "/../controller/BaseController.php");
require_once(__DIR__ . "/../controller/HomeController.php");
require_once(__DIR__ . "/../controller/UserController.php");
require_once(__DIR__ . "/../controller/AuthController.php");
require_once(__DIR__ . "/../controller/TelegramController.php");
require_once(__DIR__ . "/../controller/HandleGame.php");
require_once(__DIR__ . "/../controller/XuLyGiaoDich.php");
require_once(__DIR__ . "/../controller/AdminController.php");
require_once(__DIR__ . "/../model/AdminModel.php");
require_once(__DIR__ . "/../model/BankModel.php");

$router = new Routers;
$db = new ConnectionDB();


$router->addRoute('GET', '/a', ['BaseController', 'decryptData']);

$router->addRoute('GET', '/auth/login', ['AuthController', 'login']);
$router->addRoute('GET', '/auto/login', ['AuthController', 'autoLogin']);
$router->addRoute('POST', '/api/login', ['AuthController', 'hanldeLogin']);
$router->addRoute('GET', '/auth/register', ['AuthController', 'register']);
$router->addRoute('POST', '/api/register', ['AuthController', 'hanldeRegister']);
$router->addRoute("GET", "/logout", ['AuthController', 'logout']);
$router->addRoute('GET', '/', ['HomeController', 'index']);
$router->addRoute('GET', '/profile', ['UserController', 'profile']);
$router->addRoute('GET', '/cach-choi', ['UserController', 'Cachchoi']);
$router->addRoute('POST', '/api/change-password', ['UserController', 'changePassword']);
$router->addRoute('POST', '/api/play-game', ['HandleGame', 'submitPlayGame']);
$router->addRoute('GET', '/recharge', ['XuLyGiaoDich', 'recharge']);
$router->addRoute('POST', '/api/recharge', ['XuLyGiaoDich', 'submitRecharge']);
$router->addRoute('GET', '/withdraw', ['XuLyGiaoDich', 'withdraw']);
$router->addRoute('POST', '/api/withdraw', ['XuLyGiaoDich', 'submitWithdraw']);
$router->addRoute('POST', '/api/nvhn', ['HomeController', 'diemDanhNVHN']);
$router->addRoute('GET', '/api/get-so-du', ['UserController', 'getSodu']);
$router->addRoute('GET', '/api/cron-fake', ['XuLyGiaoDich', 'fakeLichSuChoi']);
$router->addRoute('GET', '/api/queue-jobs', ['XuLyGiaoDich', 'cronQueueJobs']);
////admin
$router->addRoute('GET', '/admin/dashboard', ['AdminController', 'dashboard']);
$router->addRoute('GET', '/admin/list-user', ['AdminController', 'listUser']);
$router->addRoute('POST', '/admin/get-list-user', ['AdminController', 'getListUser']);
$router->addRoute('GET', '/admin/edit-user/{username}', ['AdminController', 'editUser']);
///Telegramm
$router->addRoute('GET', '/telegram/set-webhook', ['TelegramController', 'setWebhook']);
$router->addRoute('GET', '/telegram/webhook', ['TelegramController', 'sendMsg']);
$router->addRoute('GET', '/telegram/pusher', ['TelegramController', 'pushRealTime']);


// Xử lý request
// return $router->handleRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$router->handleRequest($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
