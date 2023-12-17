<?php
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

    public function logout()
    {
        session_destroy();
        redirect("/auth/login");
    }
}
