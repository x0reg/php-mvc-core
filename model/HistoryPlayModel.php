<?php


class HistoryPlayModel extends AppQuery
{
    protected $table = "z_history_play";

    public function createHistory($data)
    {
        $this->insert($this->table, $data);
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
        $statement = $this->pdo->prepare("SELECT * FROM z_history_play ORDER BY id DESC LIMIT 10");
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
}
