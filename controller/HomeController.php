<?php
require_once(__DIR__ . "/../model/GameModel.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class HomeController extends BaseController
{
    protected $games;
    protected $historyPlay;

    public function __construct()
    {
        $this->games = new GameModel;
        $this->historyPlay = new HistoryPlayModel;
    }


    public function index()
    {
        $ratioChan = $this->games->getInfoGame("C");
        $ratioLe = $this->games->getInfoGame("L");
        $ratioTai = $this->games->getInfoGame("T");
        $ratioXiu = $this->games->getInfoGame("X");
        $ratioMM1 = $this->games->getInfoGame("M1");
        $ratioMM2 = $this->games->getInfoGame("M2");
        $ratioMM3 = $this->games->getInfoGame("M3");

        $getPlayByUsername = $this->historyPlay->getPlayerByUsername(getSessionUser());
        $getAllDataHistory = $this->historyPlay->getAllDataHistory();
        $lisrReward = $this->historyPlay->getReward();
        $bonus = $this->historyPlay->getUserBonus(getSessionUser());
        ///tạo CSRF
        $csrf_token = JWT::encode([
            "iat" => time(),
            "exp" => time() + 60,
            "csrf" => bin2hex(random_bytes(32)),
            "users" => getSessionUser(),
            "id" => getInfoUser("id")
        ], base64_encode($_ENV["APP_KEY"]), "HS256");

        return view("client/index", get_defined_vars());
    }


    public function diemDanhNVHN()
    {
        if (date('H:i') > '23:55' || date('H:i') < '00:05') {
            return jsonResponse([
                "status" => "error",
                "msg" => 'Chức năng đang được bảo trì, vui lòng trở lại sau 10p ^^'
            ]);
        }
        try {
            // Xác minh token
            $decoded = JWT::decode(checkString($_POST["csrf_token"]), new Key(base64_encode($_ENV["APP_KEY"]), 'HS256'));
            $username = $decoded->users;
            ////kiểm tra xem user này hôm nay chơi được bao nhiêu rồi
            $checkAmountPlay = $this->historyPlay->getAmountPlayByUser();
            if ($checkAmountPlay < 5000) {
                return jsonResponse([
                    "status" => "error",
                    "msg" => 'Bạn chưa đạt mốc Thấp nhất hãy tiếp tục chơi đi nhé'
                ]);
            }
            ///nếu đã chơi thì kiểm tra xem đang ở mốc nào
            $checkTypeReward = $this->historyPlay->getTypeReward($checkAmountPlay);
            if ($checkTypeReward) {
                $typeReward = $checkTypeReward["type"];
                $xuNhan = $checkTypeReward["reward"];
                ///kiểm tra xem hôm nay đã nhận chưa
                $checkClaimToday = $this->historyPlay->checkUserClaimToday($typeReward);
                if (!$checkClaimToday) {
                    ///cộng tiền
                    $congtien = $this->historyPlay->update("users", [
                        "money" => getInfoUser("money") + $xuNhan
                    ], [
                        "username" => $username
                    ]);

                    ///insert lịch sử
                    $this->historyPlay->insert("z_history_nvhn", [
                        "username" => $username,
                        "type" =>  $typeReward,
                        "amount" => $xuNhan,
                        "created_at" => date("Y-m-d H:i:s")
                    ]);
                    return jsonResponse([
                        "status" => "success",
                        "msg" => "Nhận thưởng thành công mốc " . $typeReward . " Bạn nhận được " . customNumberFormat($xuNhan)
                    ]);
                }
                return jsonResponse([
                    "status" => "error",
                    "msg" => "Bạn đã nhận mốc " . $typeReward . " hôm nay rồi nhé"
                ]);
            }
            return jsonResponse([
                "status" => "error",
                "msg" => "Không tồn tại mốc thưởng này vui lòng đợi cập nhật nhé"
            ]);
        } catch (Exception $e) {
            return jsonResponse(["status" => "error", "msg" => "SECRET_KEY NOT VERIFY"]);
        }
    }
}
