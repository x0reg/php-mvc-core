<?php
require_once(__DIR__ . "/TelegramController.php");
require_once(__DIR__ . "/../model/GameModel.php");
require_once(__DIR__ . "/../model/UserModel.php");
require_once(__DIR__ . "/../model/HistoryPlayModel.php");

class HandleGame extends BaseController
{

    protected $games;
    protected $users;
    protected $historyPlay;
    protected $hoaHongNhan = 1.2; ////phần trăm nhận hoa hồng

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
                    return jsonResponse(["status" => "error", "message" => "Số Xu cược không hợp lệ, Tối thiểu là " . customNumberFormat($min_cuoc) . " xu và tối đa là " . customNumberFormat($max_cuoc) . " xu"]);
                }

                ///gen trans_id;
                $sorandom = rand(000000000,999999999);
                $tranId = $noidung . $sorandom;
                $telegram->pushRealTime("Đang đợi kết Quả. MGD :" . $tranId);
                switch (strtoupper($noidung)) {
                    case 'C':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");
                        $sendDice = $telegram->sendDice();
                        
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
                        $text .= "➡️ Game: Chẵn Lẻ  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);

                        break;
                    case 'L':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");


                        $sendDice = $telegram->sendDice();
                        
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
                        $text .= "➡️ Game: Chẵn Lẻ  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);
                        break;
                    case 'T':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");
                        $sendDice = $telegram->sendDice();
                        
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
                        $text .= "➡️ Game: Tài Xỉu  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);
                        break;
                    case 'X':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");
                        $sendDice = $telegram->sendDice();
                        
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
                        $text .= "➡️ Game: Tài Xỉu  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        $text .= "➡️ Đã Cược : " . $this->games->getInfoGame($noidung)["game_name"] . "\n";

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);
                        break;
                    case 'M1':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");
                        $sendDice = $telegram->sendDice();
                        
                        if (in_array($sendDice["dice"]["value"], [1, 2, 3, 4])) {
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
                                "game" => "May Mắn",
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
                                "game" => "May Mắn",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Game: May Mắn  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        $text .= "➡️ Đã Cược : " . $this->games->getInfoGame($noidung)["game_name"] . "\n";

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);
                        break;
                    case 'M2':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");
                        $sendDice = $telegram->sendDice();
                        
                        if (in_array($sendDice["dice"]["value"], [6, 2, 3, 5])) {
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
                                "game" => "May Mắn",
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
                                "game" => "May Mắn",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Game: May Mắn  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        $text .= "➡️ Đã Cược : " . $this->games->getInfoGame($noidung)["game_name"] . "\n";

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);
                        break;
                    case 'M3':
                        ///trừ Xu
                        $trutienUsers = $this->users->update("users", [
                            "money" => $checkUser["money"] - $money
                        ], [
                            "username" => getSessionUser()
                        ]);
                        ///cộng Xu hoa hồng nè
                        if ($checkUser["ref_user"] != null) {
                            ///lấy info user 
                            $userRef = $this->users->getByUsername($checkUser["ref_user"]);
                            $xuNhanRef = ($money * $this->hoaHongNhan) / 100;
                            $conghoahong = $this->users->update("users", [
                                "money" => $userRef["money"] +  $xuNhanRef
                            ], [
                                "username" => $userRef["username"]
                            ]);
                            ///info lshh
                            $this->users->insert("lichsuhoahong", [
                                "username" => $checkUser["ref_user"],
                                "money" => $xuNhanRef,
                                "user_play" => getSessionUser(),
                                "game_play" => "Xúc Xắc Telegram"
                            ]);
                        }
                        ///gửi sms tới GR
                        $username = catUsername(getSessionUser());
                        $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</b> Đang Tung Xúc Xắc ^^");
                        $sendDice = $telegram->sendDice();
                        
                        if (in_array($sendDice["dice"]["value"], [3, 4, 5, 6])) {
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
                                "game" => "May Mắn",
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
                                "game" => "May Mắn",
                                "status" => "lose",
                                "created_at" =>  getTimeNow()
                            ]);
                        }
                        sleep(2);
                        $text = "➡️ User: " .  catUsername(getSessionUser()) . "\n";
                        $text .= "➡️ Game: May Mắn  (" . $this->games->getInfoGame($noidung)["game_name"] . ")\n\n";
                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code>" . $status . "</code>\n\n";
                        $text .= "➡️ Đã Cược : " . $this->games->getInfoGame($noidung)["game_name"] . "\n";

                        $text .= "➡️ Xu Cược: " . customNumberFormat($money) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($received_amount) . " xu\n";
                        $text .= "➡️ MGD: " . $tranId . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return jsonResponse(["status" => $jsonstt, "message" => "Số Điểm Xúc xắc: " . $sendDice["dice"]["value"] . " (" . $status . ")"]);
                        break;
                    default:
                        return jsonResponse(["status" => "error", "message" => "kHÔNG TỒN TẠI VUI LÒNG THỬ LẠI SAU"]);
                        break;
                }
            }
            return jsonResponse(["status" => "error", "message" => "Tài khoản không đủ Xu, Vui lòng nạp thêm nhé"]);
        }

        return jsonResponse(["status" => "error", "message" => "SERVER_ERROR"]);
    }
}
