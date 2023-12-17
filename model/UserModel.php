<?php


class UserModel extends AppQuery
{
    protected $table = "users";


    public function getInfoUser($username)
    {
        return $this->getByUsername($username);
    }

    public function getByUsername($username)
    {
        try {
            $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE username = :username");
            $statement->bindParam(':username', $username);
            $statement->execute();
            $query = $statement->fetch(PDO::FETCH_ASSOC);
            return $query;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
