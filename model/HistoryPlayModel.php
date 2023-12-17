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
}
