<?php

class XuLyGiaoDich extends BaseController
{

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
        return view("client/withdraw");
    }
}
