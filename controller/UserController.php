<?php

class UserController extends BaseController
{
    protected $users;
    protected $appQuery;

    public function __construct()
    {
        $this->users = new UserModel;
        $this->appQuery = new AppQuery;
    }
    public function profile()
    {
        $info = $this->users->getInfoUser(getSessionUser());

        return view("client/profile", get_defined_vars());
    }

    public function changePassword()
    {
        $password = checkString($_POST["password"]);
        $newPassword = checkString($_POST["new_passwd"]);
        $re_newpasswd = checkString($_POST["re_newpasswd"]);
        if (empty($password) || empty($newPassword) || empty($re_newpasswd)) {
            return jsonResponse(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin nhé"]);
        }
        if (strlen($newPassword) < 6) {
            return jsonResponse(["status" => "error", "message" => "Mật khẩu mới phải tối thiểu 6 kí tự"]);
        }
        $checkUser = $this->appQuery->getRows("users", ["username" => getSessionUser()]);
        if ($checkUser) {
            if ($checkUser["password"] == md5($password)) {
                if ($newPassword == $re_newpasswd) {
                    $updatePassword = $this->appQuery->update("users", [
                        "password" => md5($newPassword)
                    ], [
                        "username" => getSessionUser()
                    ]);
                    return jsonResponse(["status" => "success", "message" => "Mật khẩu đã được thay đổi thành công"]);
                }
                return jsonResponse(["status" => "error", "message" => "Mật khẩu Nhập Lại không khớp"]);
            }
            return jsonResponse(["status" => "error", "message" => "Mật khẩu cũ không chính xác"]);
        }
        return jsonResponse(["status" => "error", "message" => "Cái loz gì z"]);
    }
    
    public function cachChoi()
    {
        return view("client/cachchoi");
    }
    
       public function getSodu()
    {
        return jsonResponse([
            "money" => customNumberFormat(getInfoUser("money"))
        ]);
    }
}
