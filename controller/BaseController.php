<?php

use GuzzleHttp\Client;

class BaseController extends AppQuery
{
    public function decryptData()
    {
        // $params['user'] chứa giá trị của tham số 'user'
        $user = $_GET['user'];
        // Xử lý logic với giá trị $user ở đây
        echo "Hello " . $user;
    }

    public function fakeData()
    {
    }
    public function sendRequestHttp($method, $url, $body = null, $header = null)
    {
        $header = [];
        $body = json_encode($body);
        $client = new Client(['http_errors' => false]);
        $res = $client->request($method, $url, [
            'timeout' => 20,
            'headers' => $header,
            'body' => $body
        ]);
        return json_decode($res->getBody()->getContents(), true);
    }
}
