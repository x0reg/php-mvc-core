<?php

use Firebase\JWT\JWT;
use Symfony\Component\VarDumper\VarDumper;

function view($viewName, $data = [])
{
    // Đường dẫn tới thư mục chứa các file view
    $viewPath = 'views/';
    // Kiểm tra xem file view có tồn tại không
    $viewFile = $viewPath . $viewName . '.php';
    if (file_exists($viewFile)) {
        extract($data);
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        echo $content;
    } else {
        // Xử lý trường hợp view không tồn tại
        return throw new Exception("Error Processing Request", 1);
    }
}

function checkString($string)
{
    return trim(htmlspecialchars(addslashes($string)));
}

function customNumberFormat($number)
{
    return number_format($number, 0, ',', '.');
}

function redirect($uri)
{
    ob_start();
    header('Location: ' . $uri);
    exit;
    ob_end_flush();
}


function jsonResponse($data = [], $statusCode = 200)
{
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function getSessionUser()
{
    if ($_SESSION["users"]) {
        return $_SESSION["users"];
    } else {
        return false;
    }
}
function getInfoUser($data)
{
    if ($_SESSION["users"]) {
        $db = new AppQuery;
        $getUser = $db->getRows("users", [
            "username" => $_SESSION["users"]
        ]);
        if ($getUser) {
            return $getUser[$data];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function createPayloadMomo($stk, $ctk, $amount, $message)
{
    $key = 'momojwtkey';
    $payload = [
        "userId" => $stk,
        "name" => $ctk,
        "amount" =>  $amount,
        "transferType" => "2018",
        "message" => $message,
        "enableEditAmount" => false
    ];
    $jwt = JWT::encode($payload, $key, 'HS256');
    $tach = explode('.', $jwt);
    $dataMomo = $tach[1];
    return $dataMomo;
}
function catUsername($string)
{
    $firstThree = substr($string, 0, 3);
    $lastTwo = substr($string, -2);
    $middle = "***";
    $result = $firstThree . $middle . $lastTwo;

    return $result;
}

function randTrandID($m, $type)
{
    switch ($type) {
        case '1':
            $trandID = $m . date('Ym') . random_strings(9);
            return strtoupper($trandID);
            break;
        case '2':
            $trandID = $m . rand(0000, 99999) . random_strings(8);
            return strtoupper($trandID);
            break;
        case '3':
            $trandID = $m . rand(000000000, 9999999999);
            return strtoupper($trandID);
            break;
        default:
            return false;
            break;
    }
}

function random_strings($length_of_string)
{

    return substr(md5(getMicrotime()), 0, $length_of_string);
}


function getMicrotime()
{
    $key = round(microtime(true) * 1000);
    return $key;
}

function getTimeNow()
{
    return date("Y-m-d H:i:s");
}


function statusPlayGame($stt)
{
    switch ($stt) {
        case 'win':
            return '<span class="badge bg-success-500 text-white capitalize pill">chiến thắng</span>';
            break;
        case 'lose':
            return '<span class="badge bg-danger-500 text-white capitalize pill">thua cuộc</span>';
            break;
        case 'xuli':
            return '<span class="badge bg-warning-500 text-white capitalize pill">Đang xử lý</span>';
            break;
        case 'thanhcong':
            return '<span class="badge bg-success-500 text-white capitalize pill">thành công</span>';
            break;
        case 'thatbai':
            return '<span class="badge bg-danger-500 text-white capitalize pill">thất bại</span>';
            break;
        default:
            return "<span class='badge badge-warning'>No Case</span>";
            break;
    }
}

function statusPlayGameAdmin($stt)
{
    switch ($stt) {
        case 'win':
            return '<span class="badge badge-success">chiến thắng</span>';
            break;
        case 'lose':
            return '<span class="badge badge-danger">thua cuộc</span>';
            break;
        default:
            return "<span class='badge badge-warning'>No Case</span>";
            break;
    }
}

function customDate($days)
{
    $dateTime = new DateTime();
    switch ($days) {
        case '7':
            return $dateTime->sub(new DateInterval('P7D'))->format("Y-m-d");
            break;
        case '6':
            return $dateTime->sub(new DateInterval('P6D'))->format("Y-m-d");
            break;
        case '5':
            return $dateTime->sub(new DateInterval('P5D'))->format("Y-m-d");
            break;
        case '4':
            return $dateTime->sub(new DateInterval('P4D'))->format("Y-m-d");
            break;
        case '3':
            return $dateTime->sub(new DateInterval('P3D'))->format("Y-m-d");
            break;
        case '2':
            return $dateTime->sub(new DateInterval('P2D'))->format("Y-m-d");
            break;
        case '1':
            return $dateTime->sub(new DateInterval('P1D'))->format("Y-m-d");
            break;
        case '0':
            return $dateTime->format("Y-m-d");
            break;
        default:
            return "CASE ERROR";
            break;
    }
}
function generateRandomPhoneNumber()
{
    // Mảng chứa đầu số của các nhà mạng
    $networkPrefixes = [
        '086', '096', '097', '098', '032', '033', '034', '035', '036', '037', '038', '039', // Viettel
        '088', '091', '094', '083', '084', '085', // Vinaphone
        '089', '090', '093', '070', '079', '077', '076', '078', // Mobifone
        '092', '056', '058', // Vietnamobile
        '099', '059' // Gmobile (G Viet)
    ];

    // Chọn ngẫu nhiên một đầu số từ mảng
    $randomPrefix = $networkPrefixes[array_rand($networkPrefixes)];
    $randomNumber = sprintf("%07d", mt_rand(0, 99999999999999999));

    // Kết hợp đầu số và số còn lại để tạo số điện thoại hoàn chỉnh
    $phoneNumber = $randomPrefix . $randomNumber;

    return $phoneNumber;
}

function statusWithDraw($stt)
{
    switch ($stt) {

        default:
            return "<span class='badge badge-warning'>No Case</span>";
            break;
    }
}

function Settings($data)
{
    $app = new AppQuery();
    $stmt = $app->pdo->prepare("SELECT * FROM settings WHERE id = 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result[$data];
}


function rememberMe($token)
{
    $expires = time() + 30 * 24 * 60 * 60; // 30 ngày
    return setcookie('remember_me', $token, $expires, '/');
}
