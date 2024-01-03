<?php


class HistoryPlayModel extends AppQuery
{
    protected $table = "z_history_play";

    public function createHistory($data)
    {
        $this->insert($this->table, $data);
    }

 public function insertHistoryPlay($username, $trand_id, $value_dice, $comment, $amount, $received_amount, $game, $status, $created_at)
    {
        return $this->insert("z_history_play", [
            "username" => $username,
            "trand_id" => $trand_id,
            "value_dice" => $value_dice,
            "comment" => $comment,
            "amount" => $amount,
            "received_amount" => $received_amount,
            "game" => $game,
            "status" => $status,
            "created_at" => $created_at,
        ]);
    }

    public function getPlayerByUsername()
    {
        return $this->getByUsername($this->table, getSessionUser());
    }

    public function getByUsername($table, $username)
    {
        try {
            $statement = $this->pdo->prepare("SELECT * FROM $table WHERE username = :username ORDER BY id DESC LIMIT 5");
            $statement->bindParam(':username', $username, PDO::PARAM_INT);
            $statement->execute();
            $query = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $query;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAllDataHistory()
    {
        $statement = $this->pdo->prepare("SELECT * FROM z_history_play ORDER BY id DESC LIMIT 6");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReward()
    {
        return $this->getAll('list_reward');
    }


    public function getAmountPlayByUser()
    {
        $username = getSessionUser();
        $today = date("Y-m-d");
        try {
            $statement = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :today");
            $statement->bindParam(":username", $username);
            $statement->bindParam(":today", $today);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $amoutPlay =  $result["total_money"];
            return $amoutPlay;
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getTypeReward($amount)
    {
        try {
            $statement = $this->pdo->prepare("SELECT * FROM list_reward WHERE min <= :amount AND max > :amount");
            $statement->bindParam(":amount", $amount);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function checkUserClaimToday($type)
    {
        $username = getSessionUser();
        $created_at = date("Y-m-d");
        try {
            $statement = $this->pdo->prepare("SELECT * FROM z_history_nvhn WHERE username = :username AND type = :type AND DATE(created_at) = :created_at");
            $statement->bindParam(":username", $username);
            $statement->bindParam(":type", $type);
            $statement->bindParam(":created_at", $created_at);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }

    public function getUserBonus($username)
    {
        try {
            $statement = $this->pdo->prepare("SELECT * FROM lichsuhoahong WHERE username = :username ORDER BY id DESC LIMIT 6");
            $statement->bindParam(":username", $username);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $e) {
            echo "Query ERROR: " . $e->getMessage();
            return 0;
        }
    }
    
     public function getTotalPlayToday($username)
    {
        try {
            $today = date("Y-m-d");
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total_money FROM z_history_play WHERE username = :username AND DATE(created_at) = :today");
            $stmt->bindParam(':today', $today);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_money'] ?  $result['total_money'] : 0;
        } catch (PDOException $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }

    public function getMoc($amount)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM list_reward WHERE min <= :amount AND max > :amount");
            $stmt->bindParam(":amount", $amount);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $e) {
            die("Querry ERRORR: " . $e->getMessage());
        }
    }
}
