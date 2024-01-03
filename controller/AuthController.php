<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use phpseclib\Crypt\RSA;

require_once(__DIR__ . "/../model/UserModel.php");

class AuthController extends BaseController
{

    protected $appQuery;
    protected $users;
    protected $privateKey = "-----BEGIN RSA PRIVATE KEY-----\r\nMIICXQIBAAKBgQCg+aN5HEhfrHXCI/pLcv2Mg01gNzuAlqNhL8ojO8KwzrnEIEuq\r\nmrobjMFFPkrMXUnmY5cWsm0jxaflAtoqTf9dy1+LL5ddqNOvaPsNhSEMmIUsrppv\r\nh1ZbUZGGW6OUNeXBEDXhEF8tAjl3KuBiQFLEECUmCDiusnFoZ2w/1iOZJwIDAQAB\r\nAoGAEGDV7SCfjHxzjskyUjLk8UL6wGteNnsdLGo8WtFdwbeG1xmiGT2c6eisUWtB\r\nGQH03ugLG1gUGqulpXtgzyUYcj0spHPiUiPDAPY24DleR7lGZHMfsnu20dyu6Llp\r\nXup07OZdlqDGUm9u2uC0/I8RET0XWCbtOSr4VgdHFpMN+MECQQDbN5JOAIr+px7w\r\nuhBqOnWJbnL+VZjcq39XQ6zJQK01MWkbz0f9IKfMepMiYrldaOwYwVxoeb67uz/4\r\nfau4aCR5AkEAu/xLydU/dyUqTKV7owVDEtjFTTYIwLs7DmRe247207b6nJ3/kZhj\r\ngsm0mNnoAFYZJoNgCONUY/7CBHcvI4wCnwJBAIADmLViTcjd0QykqzdNghvKWu65\r\nD7Y1k/xiscEour0oaIfr6M8hxbt8DPX0jujEf7MJH6yHA+HfPEEhKila74kCQE/9\r\noIZG3pWlU+V/eSe6QntPkE01k+3m/c82+II2yGL4dpWUSb67eISbreRovOb/u/3+\r\nYywFB9DxA8AAsydOGYMCQQDYDDLAlytyG7EefQtDPRlGbFOOJrNRyQG+2KMEl/ti\r\nYr4ZPChxNrik1CFLxfkesoReXN8kU/8918D0GLNeVt/C\r\n-----END RSA PRIVATE KEY-----\r\n";

    public function __construct()
    {
        $this->appQuery = new AppQuery;
        $this->users = new UserModel;
    }


    public function login()
    {
        return view('client/auth/login');
    }

    public function autoLogin()
    {
        $token = $_GET["token"];
        try {
            $decoded = JWT::decode($token, new Key(base64_encode($_ENV["APP_KEY"]), 'HS256'));
            $data = $decoded->data;
            $iv = $decoded->vuabem;
            $username = openssl_decrypt($data, 'aes-256-cbc', $_ENV["APP_KEY"], 0, $iv);
            // dd($username);
            $checkUser = $this->appQuery->getRows("users", ["username" => $username]);
            // print_r($checkUser[0]["password"]);
            if ($checkUser) {
                $_SESSION['users'] = $username;
                return redirect("/");
            }
            return jsonResponse(["status" => "error", "message" => "Vui lòng lien he admin ^^"]);
        } catch (\Throwable $th) {
            return jsonResponse(["message" => "Ban hay tai lai he thong va truy cap lai ^^"]);
        }
    }

    public function hanldeLogin()
    {
        $username = checkString($_POST['username']);
        $password = checkString($_POST['password']);
        if (empty($username) || empty($password)) {
            return jsonResponse(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
        }
        $checkUser = $this->appQuery->getRows("users", ["username" => $username]);
        // print_r($checkUser[0]["password"]);
        if ($checkUser) {
            if ($checkUser["password"] == md5($password)) {
                $_SESSION['users'] = $username;
                $token = JWT::encode([
                    "username" => $username,
                    "password" => md5($password)
                ], base64_encode($_ENV["APP_KEY"]), 'HS256');
                rememberMe($token);
                return jsonResponse(["status" => "success", "message" => "Đăng Nhập thành công", "redirect" => "/"]);
            }
            return jsonResponse(["status" => "error", "message" => "Thông tin đăng nhập chưa chính xác"]);
        }
        return jsonResponse(["status" => "error", "message" => "Không tồn tại thành viên này"]);
    }

    public function register()
    {
        if ($_GET["user"]) {
            $user = checkString($_GET["user"]);
            $checkUser = $this->appQuery->getRows("users", ["username" => $user]);
            if ($checkUser) {
                $users = $user;
            }
        }
        $csrf_token = JWT::encode([
            "iat" => time(),
            "exp" => time() + 60,
            "csrf" => bin2hex(random_bytes(32)),
        ], base64_encode($_ENV["APP_KEY"]), "HS256");

        return view('client/auth/register', get_defined_vars());
    }

    public function hanldeRegister()
    {
        try {
            $decoded = JWT::decode(checkString($_POST["csrf_token"]), new Key(base64_encode($_ENV["APP_KEY"]), 'HS256'));
            // dd($_POST);
            $ref_user = checkString($_POST["ref_user"]);
            $username = checkString($_POST["username"]);
            $password = checkString($_POST["password"]);
            if (empty($username) || empty($password)) {
                return jsonResponse(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
            }
            if (strlen($username) < 6) {
                return jsonResponse(["status" => "error", "message" => "Tên tài khoản phải có tối thiểu 6 kí tự"]);
            }
            if (strlen($password) < 6) {
                return jsonResponse(["status" => "error", "message" => "Mật khẩu phải có tối thiểu 6 kí tự"]);
            }
            $checkUser = $this->appQuery->getRows("users", ["username" => $username]);
            if (!$checkUser) {
                $createNew = $this->appQuery->insert("users", [
                    "username" => preg_replace('/[^a-zA-Z0-9]/', '', $username),
                    "password" => md5($password),
                    "ref_user" => $ref_user ? $ref_user : NULL,
                    "time" => date("Y-m-d H:i:s")
                ]);
                return jsonResponse(["status" => "success", "message" => "Đăng kí thành công"]);
            }
            return jsonResponse(["status" => "error", "message" => "Tài khoản này đã tồn tại trên hệ thống"]);
        } catch (\Throwable $th) {
            return jsonResponse(["status" => "error", "message" => "Vui lòng liên hệ admin ^^"]);
        }
    }


    public function logout()
    {
        session_destroy();
        redirect("/auth/login");
    }
}
