<?php
require_once(__DIR__ . '/../vendor/autoload.php');

# Đơn vị hỗ trợ phần mềm NA Sơftware  -- 20.02.2023
session_start();
// ob_start('minify_output');
date_default_timezone_set('Asia/Ho_Chi_Minh');
$namews = $_SERVER['SERVER_NAME'];
// error_reporting(E_ALL);
// error_reporting(0);
define('SERVERNAME', 'localhost');
// define('USERNAME', 'root');
// define('PASSWORD', '');
// define('DATABASE', 'demo2');
define('USERNAME','bemmomoc_coderandom');
define('PASSWORD','bemmomoc_coderandom');
define('DATABASE','bemmomoc_coderandom');



$webcl = 'vuabem.com';
$minmaxLo = 'Min 1.000 - Max 100.000'; //nhớ sửa trong ajax nữa
$minmaxDe = 'Min 1.000 - Max 100.000'; //nhớ sửa trong ajax nữa
$tengift = "VuaBem"; // dùng cho chữ ở đầu phần giftcode
$admin = "tanne"; //  dùng cho các chức năng như chống ad rút tiền, xóa rác...vv            nên set cả cho id admin  = 4
$webtele = 'https://t.me/chanletelefromvuabem_bot';
// Tele
// khi tạo gif, các user login/sigup..vv
$token_rac = '6291195294:AAEioBc82uPWkcWN8MA5QSfDVBg1phe3UxA';
$id_rac = '5968435035';
//khi khách gửi yêu cầu rút tiền, sau khi đã bank tiền
$token_ruttien = '6191770849:AAGHgs0GlN5bLLzVvfA3_wPZhaQb0QVgFwE';
$chatid_ruttien = '5968435035';
// Báo doanh thu
$token_doanhthu = "6005754617:AAFTkplzgJiWb1uhQVzPVOzPtLjJ85mJ50o";
$id_doanhthu = "5968435035";
// tele cộng tiền
$token_congtien = '6018035802:AAHW3QHGIL8kcfgQhhw5uVTZDaBN5WSoMlw';
$chatid_congtien = '5968435035';
// Thiết Lập Random
//số lượt đặt cược
$minluotdatcuoc = 400;
$maxluotdatcuoc = 1000;
// số tiền đã rút
$minsotiendarut = 70000000;
$maxsotiendarut = 150000000;
// số lượt khách
$minkhach = 70;
$maxkhach = 180;
$momonhantien = '0366602004';
$banner = "https://i.imgur.com/UUr8v2R.jpg";
$tukhoa = 'rac101';
$web = 'bemmm.cc';
$chatadmin = 'https://m.me/135143956342273';

class MinhChien
{
    private $ketnoi;
    function connect()
    {
        if (!$this->ketnoi) {
            $this->ketnoi = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE) or die('Lỗi Database, Vui Lòng Liên Hệ Admin Báo Lỗi ^^');
            mysqli_query($this->ketnoi, "set names 'utf8'");
        }
    }
    function dis_connect()
    {
        if ($this->ketnoi) {
            mysqli_close($this->ketnoi);
        }
    }

    function site($data)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `settings` ")->fetch_array();
        return $row[$data];
    }

    function bank($data)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `bank` ")->fetch_array();
        return $row[$data];
    }

    function options($data)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `options` ")->fetch_array();
        return $row[$data];
    }

    function users($data)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' ")->fetch_array();
        return $row[$data];
    }

    function query($sql)
    {
        $this->connect();
        $row = $this->ketnoi->query($sql);
        return $row;
    }
    function cong($table, $data, $sotien, $where)
    {
        $this->connect();
        $row = $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` + '$sotien' WHERE $where ");
        return $row;
    }
    function tru($table, $data, $sotien, $where)
    {
        $this->connect();
        $row = $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` - '$sotien' WHERE $where ");
        return $row;
    }

    function insert($table, $data)
    {
        $this->connect();
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" . mysqli_real_escape_string($this->ketnoi, $value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';

        return mysqli_query($this->ketnoi, $sql);
    }
    function update($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_real_escape_string($this->ketnoi, $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        return mysqli_query($this->ketnoi, $sql);
    }

    function update_value($table, $data, $where, $value1)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_real_escape_string($this->ketnoi, $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where . ' LIMIT ' . $value1;
        return mysqli_query($this->ketnoi, $sql);
    }
    // xoaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
    // function xoa($table, $where) {
    //     $this->connect();
    //     $sql = "DELETE FROM $table WHERE $where";
    //     return mysqli_query($this->ketnoi, $sql);
    // }

    function get_list($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('SQL Lỗi Nè');
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }

    function get_row($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('SQL Lỗi Nè');
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
    function num_rows($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('SQL Lỗi Nè');
        }
        $row = mysqli_num_rows($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
}

$license = new rsaDATA();
// function encryptData($data)
// {
//     global $license;
//     $license->setPrivateKey(__DIR__ . '/clientPrivatekey.pem');
//     $license->setPublicKey(__DIR__ . '/serverPublickey.pem');
//     return $license->encryptWithPublicKey($data);
// }
// function decodecryptData($data)
// {
//     global $license;
//     $license->setPrivateKey(__DIR__ . '/serverPrivatekey.pem');
//     $license->setPublicKey(__DIR__ . '/clientPublickey.pem');
//     return $license->decryptWithPrivateKey($data);
// }
class rsaDATA
{
    // protected $private, $public;

    final public function __construct()
    {
        if (
            function_exists('openssl_get_publickey') === false ||
            function_exists('openssl_public_encrypt') === false ||
            function_exists('openssl_get_privatekey') === false ||
            function_exists('openssl_private_decrypt') === false
        ) {
            throw new RuntimeException('Không Phải Tất Cả Các Chức Năng Của OpenSSl');
        }
    }

    // final public function setPublicKey($key)
    // {
    //     if (is_null($key) || empty($key) || file_exists($key) === false) {
    //         throw new RuntimeException('Key Sai !');
    //     }

    //     $this->public = $key;

    //     return true;
    // }

    // final public function getPublicKey()
    // {
    //     return is_null($this->public) ? false : $this->public;
    // }

    // final public function setPrivateKey($key)
    // {
    //     if (is_null($key) || empty($key) || file_exists($key) === false) {
    //         throw new RuntimeException('Key Sai !');
    //     }

    //     $this->private = $key;

    //     return true;
    // }

    // final public function getPrivateKey()
    // {
    //     return is_null($this->private) ? false : $this->private;
    // }

    // final public function encryptWithPublicKey($data)
    // {
    //     if (is_null($data) || empty($data) || is_string($data) === false) {
    //         throw new RuntimeException('Needless to encrypt.');
    //     } elseif (is_null($this->public) || empty($this->public)) {
    //         throw new RuntimeException('Bạn Cần Có Key Mới Có Thể Hoạt Động !');
    //     }

    //     $key = @file_get_contents($this->public);
    //     if ($key) {
    //         $key = openssl_get_publickey($key);
    //         openssl_public_encrypt($data, $encrypted, $key);

    //         return chunk_split(base64_encode($encrypted));
    //     }

    //     return false;
    // }

    // final public function decryptWithPrivateKey($data)
    // {
    //     if (is_null($data) || empty($data) || is_string($data) === false) {
    //         throw new RuntimeException('Needless to encrypt.');
    //     } elseif (is_null($this->private) || empty($this->private)) {
    //         throw new RuntimeException('Bạn Cần Có Key Mới Có Thể Hoạt Động');
    //     }

    //     $key = @file_get_contents($this->private);
    //     if ($key) {
    //         $key = openssl_get_privatekey($key);
    //         openssl_private_decrypt(base64_decode($data), $result, $key);

    //         return $result;
    //     }
    // }

    // final public function encryptWithPrivateKey($data)
    // {
    //     if (is_null($data) || empty($data) || is_string($data) === false) {
    //         throw new RuntimeException('Bạn Cần Có Key Mới Có Thể Hoạt Động');
    //     } elseif (is_null($this->private) || empty($this->private)) {
    //         throw new RuntimeException('Bạn Cần Có Key Mới Có Thể Hoạt Động');
    //     }

    //     $key = @file_get_contents($this->private);
    //     if ($key) {
    //         $key = openssl_get_privatekey($key);
    //         openssl_private_encrypt($data, $encrypted, $key);

    //         return chunk_split(base64_encode($encrypted));
    //     }

    //     return false;
    // }

    // final public function decryptWithPublicKey($data)
    // {
    //     if (is_null($data) || empty($data) || is_string($data) === false) {
    //         throw new RuntimeException('Needless to encrypt.');
    //     } elseif (is_null($this->public) || empty($this->public)) {
    //         throw new RuntimeException('Bạn Cần Có Key Mới Có Thể Hoạt Động !');
    //     }

    //     $key = @file_get_contents($this->public);
    //     if ($key) {
    //         $key = openssl_get_publickey($key);
    //         openssl_public_decrypt(base64_decode($data), $result, $key);

    //         return $result;
    //     }
    // }
}
$system = 'online'; // chỉnh thành demo thì nó sẽ là trang web demo và sẽ không thao tác được ( khi dùng kinh doanh đối với mã nguồn thì không nên bật ) dev1
$tele_token = $token_rac; // điền token rác, id rác vào đây nè
$tele_chatid = $id_rac; // điền token rác, id rác vào đây nè

//sendtelee
function sendTele($message)
{
    global $tele_token, $tele_chatid;
    $data = http_build_query([
        'chat_id' => $tele_chatid,
        'text' => $message,
    ]);
    $url = 'https://api.telegram.org/bot' . $tele_token . '/sendMessage';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if ($data) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function templateTele($content)
{
    return "
    *" .
    $content .
    "
Thời Gian : " .
    date('Y-m-d H:i:s');
}

// $cookie_time = (300000000000000000000000);
$cookie_time = (3600 * 24 * 30000); // 30 days
$cookie_name = 'username';

// if (empty($_SESSION['username'])) {

//     if (isset($cookie_name)) {

//         if (isset($_COOKIE[$cookie_name])) {
//             $MinhChien = new MinhChien;
//             parse_str($_COOKIE[$cookie_name],$result);
//             $usr = $result["usr"];
//             $hash = $result["hash"];
//             $getUser = $MinhChien->get_row("SELECT * FROM `users` WHERE username ='$usr' and password='$hash'");
//             if ($getUser) {
//                 header('location:/');
//                 exit;
//             }
//         }
//     }
// } 

// if ( isset($_COOKIE[$cookie_name])) {
//     if (isset($_COOKIE[$cookie_name])) {
//         $MinhChien = new MinhChien;
//         parse_str($_COOKIE[$cookie_name], $result);
//         $usr = $result["usr"];
//         $hash = $result["hash"];
//         $getUser = $MinhChien->get_row("SELECT * FROM `users` WHERE username ='$usr' and password='$hash'");
//         $my_username = 'True';
//         $id = $getUser['id'];
//         $my_user = $getUser['username'];
//         $username = $getUser['username'];
//         $my_email = $getUser['email'];
//         $my_money = $getUser['money'];
//         $my_level = $getUser['capbac'];
//         $my_capbac = $getUser['capbac'];
//         if (!$getUser) {
//             header('location: /auth/login');
//             exit;
//         }
//     }
// } else {
//     $my_level = NULL;
//     $my_money = 0;
//     session_start();
//     session_destroy();
//     // header('location: /auth/login');
// }

if (check_string(isset($_SESSION['username']) && isset($_COOKIE[$cookie_name]))) {
    $MinhChien = new MinhChien;
    $getUser = $MinhChien->get_row(" SELECT * FROM `users` WHERE username = '" . $_SESSION['username'] . "' ");
    $my_username = 'True';
    $id = $getUser['id'];
    $my_user = $getUser['username'];
    $username = $getUser['username'];
    $my_email = $getUser['email'];
    $my_money = $getUser['money'];
    $my_level = $getUser['capbac'];
    $my_capbac = $getUser['capbac'];
    if (!$getUser) {
        session_start();
        session_destroy();
        header('location: /');
    }

    if ($getUser['bannd'] >= 1) {
        die('Tài Khoản Của Bạn Đã Vị Khóa Vì Vi Phạm Điều Khoản Của Chúng Tôi !');
        exit;
    } else if ($getUser['money'] < 0) {
        $MinhChien->update("users", array(
            'bannd' => 1
        ), "username = '$my_user' ");
        session_start();
        session_destroy();
        header('location: /');
        die();
    }


} else if (check_string(isset($_COOKIE[$cookie_name]) && empty($_SESSION['username']))) {
    $MinhChien = new MinhChien;
    parse_str($_COOKIE[$cookie_name], $result);
    $usr = $result["usr"];
    $hash = $result["hash"];
    $getUser = $MinhChien->get_row("SELECT * FROM `users` WHERE username ='$usr' and password='$hash'");
    if ($getUser) {
        $_SESSION['username'] = $usr;
    } else {
        header('location: /auth/login');
        die();
    }

} else {
    $my_level = NULL;
    $my_money = 0;

}


$MinhChien = new MinhChien;
$base_url = 'https://' . $_SERVER['SERVER_NAME'] . '/';
$url_site_name = strtoupper($_SERVER['SERVER_NAME']);

$time = date("Y-m-d H:i:s");

function level($number)
{
    if ($number == '0') {
        return 'Thành Viên';
    } else if ($number == '3') {
        return 'Quản Trị Viên';
    } else {
        return 'Khác';
    }
}

function statru_user($number)
{
    if ($number == 0) {
        return '<span class="badge badge-success">Hoạt Động</span>';
    } else {
        return '<span class="badge badge-danger">Đã Bị Band</span>';
    }
}



function chuyentien($data)
{
    if ($data == 'xuli') {
         return '<span class="badge bg-warning-500 text-white capitalize pill">Đang bank...</span>'; ///trạng thái rút tiền
    }
    if ($data == 'thanhcong') {
         return '<span class="badge bg-success-500 text-white capitalize pill">thành công</span>'; ///trạng thái rút tiền
    }
    if ($data == 'thatbai') {
        return '<span class="badge bg-danger-500 text-white capitalize pill">thất bại</span>'; ///trạng thái rút tiền
    } else {
      return '<span class="badge bg-danger-500 text-white capitalize pill">Có Lỗi, Liên hệ admin ^^</span>';
    }
}









// lô Lô lo , 1 file ajax, 1 cron, 1 public
function status($data)
{
    switch ($data) {
        case 'win':
            return '<span class="badge badge-success">Thắng</span>';
            break;
        case 'lose':
            return '<span class="badge badge-danger">Thua</span>';
            break;
        case 'pending':
            return '<span class="badge badge-warning">Đợi kết quả</span>';
            break;
        default:
            return '<span class="badge badge-warning">Khác</span>';
            break;
    }
}











function chanle($data)
{
    if ($data == 'chan') {
        return '<b><span style="font-size: 13px;"><code>2</code>  <code>4</code>  <code>6</code>  <code>8</code></span></b>';

    } else if ($data == 'chan2') {
        return '<span style="font-size: 13px;"><code>0</code> <code>2</code> <code>4</code> <code>6</code> <code>8</code></span>';
    } else if ($data == 'le') {
        return '<span style="font-size: 13px;"><code>1</code> <code>3</code> <code>5</code> <code>7</code></span>';
    } else if ($data == 'le2') {
        return '<span style="font-size: 13px;"><code>1</code> <code>3</code> <code>5</code> <code>7</code> <code>9</code></span>';
    } else {
        return '<span class="badge badge-warning">Khác</span>';
    }
}

function taixiu($data)
{
    if ($data == 'tai') {
        return '<span style="font-size: 13px;"><code>5</code>  <code>6</code>  <code>7</code>  <code>8</code></span>';
    } else if ($data == 'tai2') {
        return '<span style="font-size: 13px;"><code>5</code>  <code>6</code>  <code>7</code>  <code>8</code>  <code>9</code></span>';
    } else if ($data == 'xiu') {
        return '<span style="font-size: 13px;"><code>1</code>  <code>2</code>  <code>3</code>  <code>4</code></span>';
    } else if ($data == 'xiu2') {
        return '<span style="font-size: 13px;"><code>0</code>  <code>1</code>  <code>2</code>  <code>3</code>  <code>4</code></span>';
    } else {
        return '<span class="badge badge-warning">Khác</span>';
    }
}

function xien($data)
{
    if ($data == 'cx') {
        return '<span style="font-size: 13px;"><code>0</code> <code>2</code> <code>4</code></span>';
    } else if ($data == 'lt') {
        return '<span style="font-size: 13px;"><code>5</code> <code>7</code> <code>9</code></span>';
    } else if ($data == 'ct') {
        return '<span style="font-size: 13px;"><code>6</code> <code>8</code></span>';
    } else if ($data == 'lx') {
        return '<span style="font-size: 13px;"><code>1</code> <code>3</code></span>';
    } else {
        return '<span class="badge badge-warning">Khác</span>';
    }
}

function motphanba($data)
{
    if ($data == 'N1') {
        return '<span style="font-size: 10px;"><code>1</code>  <code>2</code>  <code>3</code></span>';
    } else if ($data == 'N2') {
        return '<span style="font-size: 10px;"><code>4</code>  <code>5</code>  <code>6</code></span>';
    } else if ($data == 'N3') {
        return '<span style="font-size: 10px;"><code>7</code>  <code>8</code>  <code>9</code></span>';
    } else if ($data == 'N0') {
        return '<span style="font-size: 10px;"><code>0</code>  <code>9</code></span>';
    }
}
function tong3so($data)
{
    if ($data == 'T1') {
        return '<code>02</code> - <code>13</code> - <code>17</code> - <code>19</code> </br> 
        <code>21</code> - <code>29</code> - <code>35</code> - <code>37</code> - <code>47</code> </br> 
        <code>49</code> - <code>51</code> - <code>54</code> - <code>57</code> - <code>63</code> </br> 
        <code>64</code> - <code>74</code> - <code>83</code> - <code>91</code> - <code>95</code> - <code>96</code>';
    } else if ($data == 'T2') {
        return '<code>66</code> - <code>99</code>';
    } else if ($data == 'T3') {
        return '<code>123</code> - <code>234</code> - <code>456</code> - <code>678</code> - <code>789</code>';
    } else {
        return '<span class="badge badge-warning">Khác</span>';
    }
}

function status_user($number)
{
    if ($number == 0) {
        return 'Active';
    } else {
        return 'Temporary';
    }
}



function BASE_URL($url)
{
    global $base_url;
    return $base_url . $url;
}


function tien($price)
{
    return str_replace(",", ".", number_format($price));
}



function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);

    curl_close($ch);
    return $data;
}

function random($string, $int)
{
    return substr(str_shuffle($string), 0, $int);
}

function check_url($url)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_HEADER, 1);
    curl_setopt($c, CURLOPT_NOBODY, 1);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);
    if (!curl_exec($c)) {
        return false;
    } else {
        return true;
    }
}

function getip()
{
    return $_SERVER['REMOTE_ADDR'];
}

function rand_string($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}

// Lọc input chuỗi (__STRING__)
function check_string($data)
{
    return str_replace(array('<', "'", '>', '?', "\\", '--', 'eval(', '<php'), array('', '', '', '', '', '', '', '', ''), htmlspecialchars(addslashes(strip_tags($data))));
}

function xoadau($strTitle)
{
    $strTitle = strtolower($strTitle);
    $strTitle = trim($strTitle);
    $strTitle = str_replace(' ', '-', $strTitle);
    $strTitle = preg_replace("/(ò|ó|ọ|ỏ|õ|ơ|ờ|ớ|ợ|ở|ỡ|ô|ồ|ố|ộ|ổ|ỗ)/", 'o', $strTitle);
    $strTitle = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ô|Ố|Ổ|Ộ|Ồ|Ỗ)/", 'o', $strTitle);
    $strTitle = preg_replace("/(à|á|ạ|ả|ã|ă|ằ|ắ|ặ|ẳ|ẵ|â|ầ|ấ|ậ|ẩ|ẫ)/", 'a', $strTitle);
    $strTitle = preg_replace("/(À|Á|Ạ|Ả|Ã|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ)/", 'a', $strTitle);
    $strTitle = preg_replace("/(ề|ế|ệ|ể|ê|ễ|é|è|ẻ|ẽ|ẹ)/", 'e', $strTitle);
    $strTitle = preg_replace("/(Ể|Ế|Ệ|Ể|Ê|Ễ|É|È|Ẻ|Ẽ|Ẹ)/", 'e', $strTitle);
    $strTitle = preg_replace("/(ừ|ứ|ự|ử|ư|ữ|ù|ú|ụ|ủ|ũ)/", 'u', $strTitle);
    $strTitle = preg_replace("/(Ừ|Ứ|Ự|Ử|Ư|Ữ|Ù|Ú|Ụ|Ủ|Ũ)/", 'u', $strTitle);
    $strTitle = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $strTitle);
    $strTitle = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'i', $strTitle);
    $strTitle = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $strTitle);
    $strTitle = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'y', $strTitle);
    $strTitle = str_replace('đ', 'd', $strTitle);
    $strTitle = str_replace('Đ', 'd', $strTitle);
    $strTitle = preg_replace("/[^-a-zA-Z0-9]/", '', $strTitle);
    return $strTitle;
}

function statusMomo($stt)
{
    switch ($stt) {
        case '1':
            return '<span class="badge rounded-pill bg-success"> Hoạt Động </span>';
            break;
        case '2':
            return '<span class="badge rounded-pill bg-danger"> Bảo trì </span>';
            break;
        default:
            # code...
            break;
    }
}

function optionsMomo($type)
{
    switch ($type) {
        case 'nap':
            return '<span class="badge rounded-pill bg-warning"> Chỉ Nạp </span>';
            break;
        case 'rut':
            return '<span class="badge rounded-pill bg-primary"> Chỉ Rút </span>';
            break;
        case 'naprut':
            return '<span class="badge rounded-pill bg-success"> Cho Phép Nạp + Rút </span>';
            break;
        default:
            # code...
            break;
    }
}


function showMocNvhn($total_play)
{
    $MinhChien = new MinhChien();
    $listReward = $MinhChien->get_list("SELECT * FROM `list_reward` WHERE `status` = true ");
    // print_r($listReward);
    if ($total_play > 0) {
        foreach ($listReward as $key => $listRewards) {
            if ($total_play >= $listRewards['min'] && $total_play < $listRewards['max']) {
                return "✨ Mốc Đua Hiện Tại: " . number_format($total_play) . " / " . number_format($listRewards['max']) . " ✨";
            }
        }
    } else {
        return "Bạn Chưa Tham Gia Game Nào  ᴖᴥᴖ";
    }
}
function getTotalPlay()
{
    $MinhChien = new MinhChien();
    $username = $MinhChien->users('username');
    $userData = $MinhChien->get_row("SELECT  SUM(money) as total_play FROM `lichsuchoi` WHERE `username` = '$username' AND DATE(time) = CURDATE()  ");
    $total_play = $userData['total_play'];
    return $total_play;
}

function getDataFake($data)
{
    $xz = json_decode(file_get_contents("fake_data.json"), true);

    return $xz[$data];
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
    //             '086', '096', '097', '098', '032', '033', '034', // Viettel
    //   , '091', '094', '083', '084', '085', // Vinaphone
    //     '089', '090', '093', // Mobifone
    //     '092', '056', '058', // Vietnamobile
      
    ];

    // Chọn ngẫu nhiên một đầu số từ mảng
    $randomPrefix = $networkPrefixes[array_rand($networkPrefixes)];
    $randomNumber = sprintf("%07d", mt_rand(0, 99999999999999999));

    // Kết hợp đầu số và số còn lại để tạo số điện thoại hoàn chỉnh
    $phoneNumber = $randomPrefix . $randomNumber;

    return $phoneNumber;
}

function getRatio($table, $cmt)
{
    $DB = new MinhChien();
    $getRatio = $DB->get_row("SELECT * FROM `$table` WHERE `noidung` = '$cmt' ");
    return $getRatio['tyle'];
}

////tạo csrf token để tránh giả mạo request
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Tạo token ngẫu nhiên
}
$csrfToken = $_SESSION['csrf_token'];


function catUsername($string)
{
    $firstThree = substr($string, 0, 3);
    $lastTwo = substr($string, -2);
    $middle = "***";
    $result = $firstThree . $middle . $lastTwo;

    return $result;
}

function RSA_Encrypt($content)
  {
      $publicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgmqV10XX73Ba/Tbzen+c
Foji0ZUWmFDtbhTQvBJMhcEuUtMmTYx9YhyvPvbpctzF1nT8sEBFpp/MOMo4nrv7
SmD0eCyRRaYVNWLxjXMWeJr8j8dqxWT22mbQFRgwNtPlhKVauQyQinegfXzqUBhS
713HAf/V0R8oGfRqRzGHQ8mRMUqlkBrPLrHrAi6Bqzfn/hVylhZsbNUay+YDaqEk
t6ixDY91miGsc/z7T30We+7aa1nSPPQ/zzrrKFK1SPqad/TrzRKDC94jqHiNhNsM
l2pdiw/tZcIq5FJ87mT6I2F3sqvcxNtwb3Z89qOMi5H1BHFeHfqEfkx4zJjBtvXQ
QQIDAQAB
-----END PUBLIC KEY-----";

        $rsa = new RSA();
        $rsa->loadKey($publicKey);
        $encryptedData = base64_encode($rsa->encrypt($content));
       return $encryptedData; 
 }
  