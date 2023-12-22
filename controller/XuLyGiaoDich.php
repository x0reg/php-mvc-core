<?php

class XuLyGiaoDich extends BaseController
{

    protected $appQuery;

    public function __construct()
    {
        $this->appQuery = new AppQuery;
    }
    public function recharge()
    {
        return view("client/recharge");
    }

    public function submitRecharge()
    {
        $bank = new GameModel;
        $sotien = str_replace(',', '', checkString($_POST['amount']));
        if (!is_numeric($sotien) || $sotien < 6000) {
            return jsonResponse([
                "status" => "error",
                "message" => "Số tiền tối thiểu nạp là 6000đ"
            ], 500);
        }
        $conditions = [
            [
                'OR' => [
                    ['chuc_nang' => 'nap'],
                    ['chuc_nang' => 'naprut'],
                ],
                'status' => 1,
            ],
        ];
        $getPhoneMM = $bank->getPhoneMomo($conditions);

        if ($getPhoneMM["stk"] == null) {
            return jsonResponse([
                "status" => "error",
                "message" => "Xin lỗi, Tất cả các momo đang tạm ngưng"
            ], 500);
        }

        $variables = [
            "payloadMomo" => createPayloadMomo($getPhoneMM["stk"], $getPhoneMM["ctk"], $sotien, getInfoUser("id")),
            "qr" => "https://api.qrserver.com/v1/create-qr-code/?data=2|99|" . $getPhoneMM["stk"] . "|" . $getPhoneMM["ctk"] . "||0|0|" . getInfoUser("id") . "|transfer_myqr&amp;size=200x200",
        ];

        extract($variables);
        ob_start();
        include("./views/client/layout/recharge.php");
        $htmlContent = ob_get_clean();

        return jsonResponse([
            "status" => "success",
            "html" => $htmlContent
        ]);
    }

    public function withdraw()
    {

        $bank = new BankModel;
        $history = $bank->getListWithDraw(getSessionUser());
        return view("client/withdraw", get_defined_vars());
    }

    public function submitWithdraw()
    {
        // dd($_POST);
        $min = 6000;
        $max = 5000000;
        $phi = 0.5;
        $stk = checkString($_POST["account_number"]);
        $amount = checkString($_POST["amount"]);
        $amount = str_replace(",", "", $amount);

        if ($amount > getInfoUser("money")) {
            return jsonResponse(["status" => "error", "message" => "Số tiền của bạn không đủ để rút"]);
        }
        if (empty($stk) || empty($amount)) {
            return jsonResponse(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin"]);
        }
        if (!is_numeric($amount) || !is_numeric($stk) || $amount < $min || $amount > $max) {
            return jsonResponse(["status" => "error", "message" => "Số tiền rút không hợp lệ, Số tiền phải là số và tối thiểu là " . number_format($min) . " và tối đa là " . number_format($max)]);
        }
        ///trừ tiền
        $users = $this->appQuery->update("users", [
            "money" => getInfoUser("money") - $amount,
        ], [
            "username" => getSessionUser()
        ]);
        ////tạo đơn rút
        $create = $this->appQuery->insert("lichsuruttien", [
            "trans_id" => rand(0000000000, 99999999999),
            "username" => getSessionUser(),
            "stk" => $stk,
            "money" => $amount - ($amount * $phi) / 100,
            "status" => "xuli",
            "time" => date("Y-m-d H:i:s")
        ]);

        return jsonResponse(["status" => "success", "message" => "Tạo đơn rút tiền thành công, đơn hàng xử lý trong vòng vài phút"]);
    }
}
