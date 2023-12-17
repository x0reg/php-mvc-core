<?php


class AdminController extends BaseController
{

    public function __construct()
    {
        if (getInfoUser("level") != 9) {
            return redirect("/");
        }
    }

    public function dashboard()
    {
        $admin = new AdminModel;
        $getTotalAmountUser = $admin->getTotalAmountUser();
        $getTotalUser = $admin->getTotalUser();
        $getTotalPlayToday = $admin->getTotalPlayToday();
        $getTotalUserPlayToday = $admin->getTotalUserPlayToday();

        $getAllDataHistory = $admin->getAllDataHistory();
        ////thống kê hôm nay
        $totalAmoutRecharge = $admin->getToltalAmoutRechargeToday();
        $totalAmountWithDraw = $admin->getToltalAmoutWithDrawToday();
        $getTotalAmountNVHN = $admin->getTotalAmountNVHN();
        $doanhthutoday = $totalAmoutRecharge - $totalAmountWithDraw -  $getTotalAmountNVHN;
        ////thống kê tuần này
        $getTotalAmountRechargeWeek = $admin->getTotalAmountRechargeWeek();
        $getTotalAmountWithDrawWeek = $admin->getTotalAmountWithDrawWeek();
        $getTotalAmountNVHNWeek = $admin->getTotalAmountNVHNWeek();
        $doanhthutuan =  $getTotalAmountRechargeWeek - $getTotalAmountWithDrawWeek - $getTotalAmountNVHNWeek;
        ////thống kê tháng này
        $getTotalAmountRechargeMonth = $admin->getTotalAmountRechargeMonth();
        $getTotalAmountWithdrawMonth = $admin->getTotalAmountWithdrawMonth();
        $getTotalAmountNVHNMonth = $admin->getTotalAmountNVHNMonth();
        $doanhthumonth =   $getTotalAmountRechargeMonth - $getTotalAmountWithdrawMonth -  $getTotalAmountNVHNMonth;
        return view('admin/dashboard', get_defined_vars());
    }

    public function listUser()
    {

        return view("/admin/list-user", get_defined_vars());
    }

    public function getListUser()
    {
        $admin = new AdminModel;
        $listUsers = []; // Khởi tạo mảng rỗng
        $allUser = $admin->getAllUser();

        foreach ($allUser as $key => $value) {
            ///tính tổng doanh thu 
            $tongdoanhthu = $admin->getTotalDoanhThuByUser($value["username"]);
            // ///tổng doanh thu 7days
            $tongdoanhthu7days = ($admin->getDoanhThuDaysByReceivedByUser("tong7ngay", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("tong7ngay", $value["username"]));
            ////doanh thu hôm nay
            $doanhthuhomnay = ($admin->getDoanhThuDaysByReceivedByUser("ngayhomnay", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("ngayhomnay", $value["username"]));
            // ////1 ngày trước
            $doanhthu1ngaytruoc = ($admin->getDoanhThuDaysByReceivedByUser("motngaytruoc", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("motngaytruoc", $value["username"]));
            // ////2 ngày trước
            $doanhthu2ngaytruoc = ($admin->getDoanhThuDaysByReceivedByUser("haingaytruoc", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("haingaytruoc", $value["username"]));
            // ////3 ngày trước
            $doanhthu3ngaytruoc = ($admin->getDoanhThuDaysByReceivedByUser("bangaytruoc", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("bangaytruoc", $value["username"]));
            // ////4 ngày trước
            $doanhthu4ngaytruoc = ($admin->getDoanhThuDaysByReceivedByUser("bonngaytruoc", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("bonngaytruoc", $value["username"]));
            // ////5 ngày trước
            $doanhthu5ngaytruoc = ($admin->getDoanhThuDaysByReceivedByUser("namngaytruoc", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("namngaytruoc", $value["username"]));
            // ////6 ngày trước
            $doanhthu6ngaytruoc = ($admin->getDoanhThuDaysByReceivedByUser("saungaytruoc", $value["username"])) - ($admin->getDoanhThuDaysByPlayByUser("saungaytruoc", $value["username"]));

            // Tạo mảng mới chứa id và username từ mỗi mảng trong $allUser
            $userDetails = [
                "id" => $value["id"],
                "username" => $value["username"],
                "money" => customNumberFormat($value["money"]),
                "tongdoanhthu" => customNumberFormat($tongdoanhthu),
                "tongdoanhthu7ngay" =>  customNumberFormat($tongdoanhthu7days),
                "ngayhomnay" => customNumberFormat($doanhthuhomnay),
                "motngaytruoc" => customNumberFormat($doanhthu1ngaytruoc),
                "haingaytruoc" => customNumberFormat($doanhthu2ngaytruoc),
                "bangaytruoc" => customNumberFormat($doanhthu3ngaytruoc),
                "bonngaytruoc" => customNumberFormat($doanhthu4ngaytruoc),
                "namngaytruoc" => customNumberFormat($doanhthu5ngaytruoc),
                "saungaytruoc" => customNumberFormat($doanhthu6ngaytruoc),
                "addColums" => '<a href="/admin/edit-user/' . $value["username"] . '" class="btn btn-app"><i class="fas fa-edit"></i> Edit</a>'
            ];
            $listUsers[] = $userDetails;
        }
        return jsonResponse([
            "data" => $listUsers
        ]);
    }

    public function editUser($username)
    {
        // dd($username);
        try {
            $users = new UserModel;
            $getUser = $users->getByUsername(checkString($username));
            if ($getUser) {
                dd($getUser);
            } else {
                return jsonResponse(["message" => "Không tồn tại user này"]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
