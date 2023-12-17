<?php
require_once(__DIR__ . "./TelegramController.php");
require_once(__DIR__ . "/../model/GameModel.php");
require_once(__DIR__ . "/../model/UserModel.php");
require_once(__DIR__ . "/../model/HistoryPlayModel.php");

class HandleGame extends BaseController
{

    protected $games;
    protected $users;
    protected $historyPlay;
    public function __construct()
    {
        $this->users = new UserModel;
        $this->games = new GameModel;
        $this->historyPlay = new HistoryPlayModel;
    }
    public function submitPlayGame()
    {
        $telegram = new TelegramController;
        $noidung = checkString($_POST["noidung"]);
        $money = checkString($_POST["money"]);
        $money = intval(str_replace(".", "", $money));
        $checkUser = $this->users->getInfoUser(getSessionUser());
        if ($checkUser) {
            // dd($checkUser);
            if ($checkUser["money"] >= $money) {
                $min_cuoc = $this->games->getInfoGame($noidung)["min_cuoc"];
                $max_cuoc = $this->games->getInfoGame($noidung)["max_cuoc"];
                $ratio =  $this->games->getInfoGame($noidung)["ratio"];
                if (empty($noidung) || empty($money)) {
                    return jsonResponse(["status" => "error", "message" => "Vui lòng nhập đủ thông tin"]);
                }

                if ($money < $min_cuoc || $money > $max_cuoc || $money < 0) {
                    return jsonResponse(["status" => "error", "message" => "Số tiền cược không hợp lệ, Tối thiểu là " . customNumberFormat($min_cuoc) . " xu và tối đa là " . customNumberFormat($max_cuoc) . " xu"]);
                }

                ///gen trans_id;
                $tranId = randTrandID($noidung, 1);
                $telegram->pushRealTime("Đang đợi Kết quả xúc xắc. Mã Giao Dịch :" . $tranId);
                switch (strtoupper($noidung)) {
                    case 'C':
                        ///trừ tiền
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("THÔNG BÁO QUAY THƯỞNG CHO USER :<b>" . $username . "</b>.");
                        $sendDice = $telegram->sendDice();
                        $telegram->sendMsgToGroup("Đợi Kết quả từ xúc xắc ...");
                        if (in_array($sendDice["dice"]["value"], [2, 4, 6])) {
                            $received_amount = intval($money * $ratio);
                            $status = GameModel::STATUS_WIN;
                            $jsonstt = "success";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Chẵn Lẻ",
                                "status" => "win",
                                "created_at" =>  getTimeNow()

                            ]);
                            $this->users->update("users", [
                                "money" => $checkUser["money"] + $received_amount - $money
                            ], [
                                "username" => getSessionUser()
                            ]);
                        } else {
                            $received_amount = 0;
                            $status = GameModel::STATUS_LOSE;
                            $jsonstt = "error";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Chẵn Lẻ",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Trò Chơi: Chẵn Lẻ \n";
                        $text .= "➡️ Kết quả Xúc Xắc: <b>" . $sendDice["dice"]["value"] . "</b>\n";
                        $text .= "➡️ Đã Cược: " . $this->games->getInfoGame($noidung)["game_name"] . "\n";
                        $text .= "➡️ Trạng Thái: " . $status . "\n";
                        $text .= "➡️ Tiền Cược: " . customNumberFormat($money) . "\n";
                        $text .= "➡️ Tiền Nhận: " . customNumberFormat($received_amount) . "\n";
                        $text .= "➡️ Mã Giao Dịch: " . $tranId . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Trạng Thái " . $status]);
                        break;
                    case 'L':
                        ///trừ tiền
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("THÔNG BÁO QUAY THƯỞNG CHO USER :<b>" . $username . "</b>.");
                        $sendDice = $telegram->sendDice();
                        $telegram->sendMsgToGroup("Đợi Kết quả từ xúc xắc ...");
                        if (in_array($sendDice["dice"]["value"], [1, 3, 5])) {
                            $received_amount = intval($money * $ratio);
                            $status = GameModel::STATUS_WIN;
                            $jsonstt = "success";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "comment" => $noidung,
                                "value_dice" => $sendDice["dice"]["value"],
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Chẵn Lẻ",
                                "status" => "win",
                                "created_at" =>  getTimeNow()

                            ]);
                            $this->users->update("users", [
                                "money" => $checkUser["money"] + $received_amount - $money
                            ], [
                                "username" => getSessionUser()
                            ]);
                        } else {
                            $received_amount = 0;
                            $status = GameModel::STATUS_LOSE;
                            $jsonstt = "error";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Chẵn Lẻ",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Trò Chơi: Chẵn Lẻ \n";
                        $text .= "➡️ Kết quả Xúc Xắc: <b>" . $sendDice["dice"]["value"] . "</b>\n";
                        $text .= "➡️ Đã Cược: " . $this->games->getInfoGame($noidung)["game_name"] . "\n";
                        $text .= "➡️ Trạng Thái: " . $status . "\n";
                        $text .= "➡️ Tiền Cược: " . customNumberFormat($money) . "\n";
                        $text .= "➡️ Tiền Nhận: " . customNumberFormat($received_amount) . "\n";
                        $text .= "➡️ Mã Giao Dịch: " . $tranId . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Trạng Thái " . $status]);
                        break;
                    case 'T':
                        ///trừ tiền
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("THÔNG BÁO QUAY THƯỞNG CHO USER :<b>" . $username . "</b>.");
                        $sendDice = $telegram->sendDice();
                        $telegram->sendMsgToGroup("Đợi Kết quả từ xúc xắc ...");
                        if (in_array($sendDice["dice"]["value"], [4, 5, 6])) {
                            $received_amount = intval($money * $ratio);
                            $status = GameModel::STATUS_WIN;
                            $jsonstt = "success";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Tài Xỉu",
                                "status" => "win",
                                "created_at" =>  getTimeNow()

                            ]);
                            $this->users->update("users", [
                                "money" => $checkUser["money"] + $received_amount - $money
                            ], [
                                "username" => getSessionUser()
                            ]);
                        } else {
                            $received_amount = 0;
                            $status = GameModel::STATUS_LOSE;
                            $jsonstt = "error";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Tài Xỉu",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Trò Chơi: Tài Xỉu \n";
                        $text .= "➡️ Kết quả Xúc Xắc: <b>" . $sendDice["dice"]["value"] . "</b>\n";
                        $text .= "➡️ Đã Cược: " . $this->games->getInfoGame($noidung)["game_name"] . "\n";
                        $text .= "➡️ Trạng Thái: " . $status . "\n";
                        $text .= "➡️ Tiền Cược: " . customNumberFormat($money) . "\n";
                        $text .= "➡️ Tiền Nhận: " . customNumberFormat($received_amount) . "\n";
                        $text .= "➡️ Mã Giao Dịch: " . $tranId . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Trạng Thái " . $status]);
                        break;
                    case 'X':
                        ///trừ tiền
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("THÔNG BÁO QUAY THƯỞNG CHO USER :<b>" . $username . "</b>.");
                        $sendDice = $telegram->sendDice();
                        $telegram->sendMsgToGroup("Đợi Kết quả từ xúc xắc ...");
                        if (in_array($sendDice["dice"]["value"], [1, 2, 3])) {
                            $received_amount = intval($money * $ratio);
                            $status = GameModel::STATUS_WIN;
                            $jsonstt = "success";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Tài Xỉu",
                                "status" => "win",
                                "created_at" =>  getTimeNow()

                            ]);
                            $this->users->update("users", [
                                "money" => $checkUser["money"] + $received_amount - $money
                            ], [
                                "username" => getSessionUser()
                            ]);
                        } else {
                            $received_amount = 0;
                            $status = GameModel::STATUS_LOSE;
                            $jsonstt = "error";
                            $this->historyPlay->createHistory([
                                "username" => getSessionUser(),
                                "trand_id" => $tranId,
                                "value_dice" => $sendDice["dice"]["value"],
                                "comment" => $noidung,
                                "amount" => $money,
                                "received_amount" => $received_amount,
                                "game" => "Tài Xỉu",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Trò Chơi: Tài Xỉu \n";
                        $text .= "➡️ Kết quả Xúc Xắc: <b>" . $sendDice["dice"]["value"] . "</b>\n";
                        $text .= "➡️ Đã Cược : " . $this->games->getInfoGame($noidung)["game_name"] . "\n";
                        $text .= "➡️ Trạng Thái: " . $status . "\n";
                        $text .= "➡️ Tiền Cược: " . customNumberFormat($money) . "\n";
                        $text .= "➡️ Tiền Nhận: " . customNumberFormat($received_amount) . "\n";
                        $text .= "➡️ Mã Giao Dịch: " . $tranId . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Trạng Thái " . $status]);
                        break;
                    default:
                        return jsonResponse(["status" => "error", "message" => "kHÔNG TỒN TẠI VUI LÒNG THỬ LẠI SAU"]);
                        break;
                }
            }
            return jsonResponse(["status" => "error", "message" => "Tài khoản không đủ tiền, Vui lòng nạp thêm nhé"]);
        }

        return jsonResponse(["status" => "error", "message" => "SERVER_ERROR"]);
    }
}
