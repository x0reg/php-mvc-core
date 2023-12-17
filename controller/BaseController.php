<?php

use GuzzleHttp\Client;

class BaseController extends AppQuery
{
    public function decryptData()
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của ngày hiện tại
            $startOfDay = date("Y-m-d 00:00:00");
            $endOfDay = date("Y-m-d 23:59:59");

            $stmt = $this->pdo->prepare("SELECT COUNT(DISTINCT username) as total_users FROM z_history_play WHERE created_at >= :startOfDay AND created_at <= :endOfDay");
            $stmt->bindParam(':startOfDay', $startOfDay);
            $stmt->bindParam(':endOfDay', $endOfDay);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($result['total_users']);
        } catch (PDOException $e) {
            // Xử lý lỗi theo nhu cầu cụ thể của bạn
            echo "Query ERROR: " . $e->getMessage();
            return 0; // hoặc giá trị mặc định khác
        }
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
