<?php

class XuLyGiaoDich extends BaseController
{

    protected $appQuery;
    protected $users;
    
    public function __construct()
    {
        $this->appQuery = new AppQuery;
        $this->users = new UserModel;
    }
    public function recharge()
    {
        return view("client/recharge");
    }

    public function submitRecharge()
    {
        $bank = new GameModel;
        $sotien = str_replace('.', '', checkString($_POST['amount']));
        if (!is_numeric($sotien) || $sotien < 6000) {
            return jsonResponse([
                "status" => "error",
                "message" => "Số Xu tối thiểu nạp là 6000đ"
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
         $info = $this->users->getInfoUser(getSessionUser());
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
        $amount = str_replace(".", "", $amount);

        if ($amount > getInfoUser("money")) {
            return jsonResponse(["status" => "error", "message" => "Số Xu của bạn không đủ để rút"]);
        }
        if (empty($stk) || empty($amount)) {
            return jsonResponse(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin"]);
        }
        if (!is_numeric($amount)  || $amount < $min || $amount > $max) {
            return jsonResponse(["status" => "error", "message" => "Số Xu rút không hợp lệ, Số Xu phải là số và tối thiểu là " . number_format($min) . " và tối đa là " . number_format($max)]);
        }
                if (!is_numeric($stk)) {
            return jsonResponse(["status" => "error", "message" => "Số tài khoản bạn rút không hợp lệ, vui lòng liên hệ Admin"]);
        }
        ///trừ Xu
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
            "trangthai" => "no",
            "time" => date("Y-m-d H:i:s")
        ]);

        return jsonResponse(["status" => "success", "message" => "Tạo đơn rút Xu thành công, đơn hàng xử lý trong vòng vài phút"]);
    }
    
public function fakeLichSuChoi()
{
    $arr_game = [
        'Chẵn Lẻ',
        'May Mắn',
        'Tài Xỉu',
    ];
    $arr_money = [
        '10000',
        '20000',
        '30000',
        '40000',
        '50000',
        '60000',
        '70000',
        '80000',
        '90000',
        '100000',
        '200000'
    ];

    $fakeUser = generateRandomPhoneNumber(); // Generate once outside the loop
    $money = array_rand($arr_money);
    $game = array_rand($arr_game);

    $randomIterationsFake = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15,
        6, 7, 8,
        6, 7, 8,
        6, 7, 8,
        6, 7, 8,
        5, 6, 7, 8,
        5, 6, 7, 8,
        5, 6, 7, 8,
        5, 6, 7, 8,
        5, 6, 7, 8];
    $loop = $randomIterationsFake[array_rand($randomIterationsFake)];

    $dataPayload = []; // Khởi tạo mảng

    for ($i = 0; $i < $loop; $i++) {
        if ($arr_game[$game] == "Chẵn Lẻ") {
            $options = ["C", "L"];
            $randomIndex = array_rand($options);
            $cmt = $options[$randomIndex];
            $dataPayload[] = [
                "username" => $fakeUser,
                "comment" => $cmt,
                "amount" => $arr_money[$money],
                "game" => "Chẵn Lẻ",
            ];
        }
        if ($arr_game[$game] == "May Mắn") {
            $options = ["MM1", "MM2", "MM3"];
            $randomIndex = array_rand($options);
            $cmt = $options[$randomIndex];
            $dataPayload[] = [
                "username" => $fakeUser,
                "comment" => $cmt,
                "amount" => $arr_money[$money],
                "game" => "May Mắn",
            ];
        }
        if ($arr_game[$game] == "Tài Xỉu") {
            $options = ["T", "X"];
            $randomIndex = array_rand($options);
            $cmt = $options[$randomIndex];
            $dataPayload[] = [
                "username" => $fakeUser,
                "comment" => $cmt,
                "amount" => $arr_money[$money],
                "game" => "Tài Xỉu",
            ];
        }

        $this->appQuery->insert("z_queue_jobs", [
            "payload" => json_encode(end($dataPayload)), // Lấy giá trị cuối cùng của mảng
            "created_at" => getTimeNow()
        ]);
        echo "success";
    }
}

    public function cronQueueJobs()
    {
        $historyPlay = new HistoryPlayModel;
        $stmt = $this->appQuery->pdo->prepare("SELECT * FROM z_queue_jobs WHERE status = 0 LIMIT 1");
        $stmt->execute();
        $job = $stmt->fetch(PDO::FETCH_ASSOC);
        $data = json_decode($job["payload"], true);
        if ($job) {
            // Cập nhật trạng thái của công việc sau khi xử lý
            $xoa = $this->appQuery->delete("z_queue_jobs", [
                "id" => $job['id']
            ]);
            // Xử lý công việc
            $telegram = new TelegramController;
            $telegram->sendMsgToGroup("┏━━━━━━━━━━━━━━━━┓\n<b>" . catUsername($data["username"]) . "</b> Đang Tung Xúc Xắc ^^ ");
            $sendDice = $telegram->sendDice();
            // $telegram->sendMsgToGroup("Đợi Kết quả từ xúc xắc ...");
            switch ($data["comment"]) {
                case 'C':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [2, 4, 6])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Chẵn)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.95) . " xu\n";
                        $text .= "➡️ MGD: C" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], $data["amount"] * 1.9, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Chẵn)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: C" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                case 'L':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [1, 3, 5])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Lẻ)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
 
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.95) . " xu\n";
                        $text .= "➡️ MGD: L" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"],"FAKE", $data["amount"], $data["amount"] * 1.9, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Lẻ)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: L" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                case 'T':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [4, 5, 6])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Tài)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.95) . " xu\n";
                        $text .= "➡️ MGD: T" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], $data["amount"] * 1.9, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Tài)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: T" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                case 'X':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [1, 2, 3])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Xỉu)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.95) . " xu\n";
                        $text .= "➡️ MGD: X" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], $data["amount"] * 1.9, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (Xỉu)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: X" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                case 'MM1':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [1, 2, 3, 4])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (May Mắn 1)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.4) . " xu\n";
                        $text .= "➡️ MGD: M" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], $data["amount"] * 1.4, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (May Mắn 1)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: C" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                case 'MM2':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [2, 3, 5, 6])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (May Mắn 2)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.4) . " xu\n";
                        $text .= "➡️ MGD: M" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], $data["amount"] * 1.4, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (May Mắn 2)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: C" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                case 'MM3':
                    sleep(2);
                    if (in_array($sendDice["dice"]["value"], [3, 4, 5, 6])) {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (May Mắn 3)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Chiến Thắng ✅ </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: " . customNumberFormat($data["amount"] * 1.4) . " xu\n";
                        $text .= "➡️ MGD: M" . rand(100000000, 999999999) . "\n";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], $data["amount"] * 1.4, $data["game"], "win", getTimeNow());
                    } else {
                        $text = "➡️ User: " .  catUsername($data["username"]) . "\n";
                        $text .= "➡️ Game: " . $data["game"] . "  (May Mắn 3)\n\n";

                        $text .= "⭐ <b>Kết quả: " . $sendDice["dice"]["value"] . "</b> <code> Thua </code>\n\n";
                        
                        $text .= "➡️ Xu Cược: " . customNumberFormat($data["amount"]) . " xu\n";
                        $text .= "➡️ Xu Nhận: 0 xu\n";
                        $text .= "➡️ MGD: C" . rand(100000000, 999999999) . "\n┗━━━━━━━━━━━━━━━━┛";
                        $telegram->sendMsgToGroup($text, $sendDice["message_id"]);
                        return $historyPlay->insertHistoryPlay($data["username"], rand(000000000, 9999999999), $sendDice["dice"]["value"], "FAKE", $data["amount"], 0, $data["game"], "lose", getTimeNow());
                    }
                    break;
                default:
                    # code...
                    break;
            }
        } else {
            echo "No job to process.";
        }
    }
}
