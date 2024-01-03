<?php

class AdminModel extends AppQuery
{

    public function getAllDataHistory()
    {
        try {
            $statement = $this->pdo->prepare("SELECT * FROM z_history_play WHERE comment != 'FAKE' ORDER BY id DESC");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }
    
       public function getAllTongNhan()
    {
        try {
            // $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT SUM(amount) as total_money FROM z_history_play");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getAllTongTra()
    {
        try {
            // $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT SUM(received_amount) as total_money FROM z_history_play");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getTotalNVHN()
    {
        try {
            // $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT SUM(amount) as total_money FROM z_history_nvhn");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getToltalAmoutRechargeToday($today)
    {
        try {
            // $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT SUM(amount) as total_money FROM z_history_play WHERE DATE(created_at) = :today");
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getToltalAmoutWithDrawToday($today)
    {
        try {
            // $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT SUM(received_amount) as total_money FROM z_history_play WHERE DATE(created_at) = :today");
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getTotalAmountNVHN($today)
    {
        try {
            // $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT SUM(amount) as total_money FROM z_history_nvhn WHERE DATE(created_at) = :today");
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getTotalAmountUser()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(money) as total_money FROM users");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getTotalUser()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as total_user FROM users");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_user'] ?  $result['total_user'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getTotalAmountRechargeWeek($startOfWeek, $endOfWeek)
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của tuần này
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE DATE(created_at) >= :startOfWeek AND DATE(created_at) <= :endOfWeek");
            $stmt->bindParam(':startOfWeek', $startOfWeek);
            $stmt->bindParam(':endOfWeek', $endOfWeek);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'];
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }
    public function getTotalAmountWithDrawWeek($startOfWeek, $endOfWeek)
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của tuần này
            // $startOfWeek = date("Y-m-d", strtotime("monday this week"));
            // $endOfWeek = date("Y-m-d", strtotime("sunday this week"));
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE DATE(created_at) >= :startOfWeek AND DATE(created_at) <= :endOfWeek");
            $stmt->bindParam(':startOfWeek', $startOfWeek);
            $stmt->bindParam(':endOfWeek', $endOfWeek);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'];
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getTotalAmountNVHNWeek($startOfWeek, $endOfWeek)
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của tuần này
            // $startOfWeek = date("Y-m-d", strtotime("monday this week"));
            // $endOfWeek = date("Y-m-d", strtotime("sunday this week"));
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_nvhn WHERE DATE(created_at) >= :startOfWeek AND DATE(created_at) <= :endOfWeek");
            $stmt->bindParam(':startOfWeek', $startOfWeek);
            $stmt->bindParam(':endOfWeek', $endOfWeek);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'];
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getTotalAmountRechargeMonth($startOfMonth, $endOfMonth)
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của tháng này
            // $startOfMonth = date("Y-m-01");
            // $endOfMonth = date("Y-m-t");
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE DATE(created_at) >= :startOfMonth AND DATE(created_at) <= :endOfMonth");
            $stmt->bindParam(':startOfMonth', $startOfMonth);
            $stmt->bindParam(':endOfMonth', $endOfMonth);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'];
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }
    public function getTotalAmountWithdrawMonth($startOfMonth, $endOfMonth)
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của tháng này
            // $startOfMonth = date("Y-m-01");
            // $endOfMonth = date("Y-m-t");
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE DATE(created_at) >= :startOfMonth AND DATE(created_at) <= :endOfMonth");
            $stmt->bindParam(':startOfMonth', $startOfMonth);
            $stmt->bindParam(':endOfMonth', $endOfMonth);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'];
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getTotalAmountNVHNMonth($startOfMonth, $endOfMonth)
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của tuần này
            // $startOfMonth = date("Y-m-01");
            // $endOfMonth = date("Y-m-t");
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_nvhn WHERE DATE(created_at) >= :startOfMonth AND DATE(created_at) <= :endOfMonth");
            $stmt->bindParam(':startOfMonth', $startOfMonth);
            $stmt->bindParam(':endOfMonth', $endOfMonth);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'];
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }


    public function getTotalPlayToday()
    {
        try {
            $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as total_user_play FROM z_history_play WHERE DATE(created_at) = :today");
            $stmt->bindParam(':today', $today);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_user_play'] ?  $result['total_user_play'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getTotalUserPlayToday()
    {
        try {
            // Lấy ngày bắt đầu và kết thúc của ngày hiện tại
            $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT COUNT(DISTINCT username) as total_users_play FROM z_history_play WHERE DATE(created_at) = :today ");
            $stmt->bindParam(':today', $today);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result['total_users_play']);
        } catch (PDOException $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getAllUser()
    {
        return $this->getAll('users');
    }


    public function getDoanhThuDaysByPlayByUser($days, $username)
    {
        $today = customDate(0);
        $motngaytruoc = customDate(1);
        $haingaytruoc = customDate(2);
        $bangaytruoc = customDate(3);
        $bonngaytruoc = customDate(4);
        $namngaytruoc = customDate(5);
        $saungaytruoc = customDate(6);
        $bayngaytruoc = customDate(7);
        try {
            switch ($days) {
                case 'tong7ngay':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) <= :startDays AND DATE(created_at) >= :endDays ");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $today);
                    $statement->bindParam(":endDays", $bayngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'ngayhomnay':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $today);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'motngaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $motngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'haingaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $haingaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'bangaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $bangaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'bonngaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $bonngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'namngaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $namngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'saungaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $saungaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                default:
                    return 0;
                    break;
            }
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getDoanhThuDaysByReceivedByUser($days, $username)
    {
        $today = customDate(0);
        $motngaytruoc = customDate(1);
        $haingaytruoc = customDate(2);
        $bangaytruoc = customDate(3);
        $bonngaytruoc = customDate(4);
        $namngaytruoc = customDate(5);
        $saungaytruoc = customDate(6);
        $bayngaytruoc = customDate(7);
        try {
            switch ($days) {
                case 'tong7ngay':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) <= :startDays AND DATE(created_at) >= :endDays ");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $today);
                    $statement->bindParam(":endDays", $bayngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'ngayhomnay':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $today);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'motngaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $motngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'haingaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $haingaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'bangaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $bangaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'bonngaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $bonngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'namngaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $namngaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                case 'saungaytruoc':
                    $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :startDays");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":startDays", $saungaytruoc);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return  $result["total_money"];
                    break;
                default:
                    return 0;
                    break;
            }
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getTotalDoanhThuByUser($username)
    {
        try {
            $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username");
            $statement->bindParam(":username", $username);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $amoutPlay =  $result["total_money"];

            $statement = $this->pdo->prepare("SELECT COALESCE(SUM(received_amount), 0) as total_received_amount FROM z_history_play WHERE username = :username");
            $statement->bindParam(":username", $username);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $amoutReceived =  $result["total_received_amount"];

            return $amoutReceived - $amoutPlay;
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }
}
