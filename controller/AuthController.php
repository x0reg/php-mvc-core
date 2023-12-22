<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once(__DIR__ . "/../model/UserModel.php");

class AuthController extends BaseController
{

    protected $appQuery;

    public function __construct()
    {
        $this->appQuery = new AppQuery;
    }

    public function login()
    {
        return view('client/auth/login');
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
                return jsonResponse(["status" => "success", "message" => "Đăng Nhập thành công", "redirect" => "/"]);
            }
            return jsonResponse(["status" => "error", "message" => "Thông tin đăng nhập không chính xác"]);
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
            return jsonResponse(["status" => "error", "message" => "CSRF-TOKEN MISMATCH"]);
        }
    }


    public function logout()
    {
        session_destroy();
        redirect("/auth/login");
    }
}
