<?php

use Telegram\Bot\Api;

class TelegramController extends BaseController
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api($_ENV["TOKEN_BOT_TELEHRAM"]);
    }


    public function setWebhook()
    {
        if ($_ENV["APP_DEBUG"] == "true") {
            $url = "https://2062-2405-4802-a09d-c0a0-b94d-20d5-bc07-5c12.ngrok-free.app";
        } else {
            $url = "https:://" . $_SERVER["HTTP_HOST"] . "/telegram/webhook";
        }
        $response = $this->telegram->setWebhook(['url' => $url]);
        return jsonResponse(["status" => "success", "message" =>  $response]);
    }

    public function sendDice()
    {
        $sendDice = $this->telegram->sendDice([
            "chat_id" => $_ENV["ID_GROUP_TELEGRAM"],
        ]);
        // echo $sendDice["dice"]["value"];
        return $sendDice;
    }

    public function sendMsgToGroup($text, $msg_id = null)
    {
        $sendMsg = $this->telegram->sendMessage([
            "chat_id" => $_ENV["ID_GROUP_TELEGRAM"],
            "text" => $text,
            "reply_to_message_id" => $msg_id,
            "parse_mode" => "html"
        ]);
        return $sendMsg;
    }

    public function pushRealTime($msg)
    {
        $options = [
            'cluster' => $_ENV["PUSHER_CLUSTER"],
            'useTLS' => true,
        ];

        $pusher = new Pusher\Pusher(
            $_ENV["PUSHER_KEY"],
            $_ENV["PUSHER_SECRET"],
            $_ENV["PUSHER_APP_ID"],
            $options
        );
        $data['message'] = $msg;
        return $pusher->trigger('my-channel', getSessionUser(), $data);
    }
}
