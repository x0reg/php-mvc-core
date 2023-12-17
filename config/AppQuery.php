<?php
class AppQuery extends ConnectionDB
{

    public function getAll($table)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $table");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRows($tableName, $conditions, $orderBy = null)
    {
        try {
            $sql = "SELECT * FROM $tableName WHERE ";
            $whereConditions = [];
            foreach ($conditions as $column => $value) {
                $whereConditions[] = "$column = :$column";
            }
            $sql .= implode(' AND ', $whereConditions);

            // Thêm câu lệnh ORDER BY nếu được chỉ định
            if ($orderBy !== null) {
                $sql .= " ORDER BY $orderBy";
            }

            $stmt = $this->pdo->prepare($sql);
            foreach ($conditions as $column => $value) {
                $stmt->bindParam(":$column", $value);
            }
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows[0];
        } catch (PDOException $e) {
            die('Query ERROR : ' . $e->getMessage());
        }
    }



    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        $values = array_values($data);
        for ($i = 0; $i < count($values); $i++) {
            $stmt->bindValue(($i + 1), $values[$i]);
        }
        $result = $stmt->execute();

        return $result;
    }

    public function update($table, $data, $whereConditions)
    {
        // Xây dựng phần SET
        ///whereConditions là 1 mảng với key và value
        $updateColumns = array_map(function ($key, $value) {
            return "$key = :$key";
        }, array_keys($data), $data);
        $updateColumnsString = implode(', ', $updateColumns);
        $whereConditionsString = implode(' AND ', array_map(function ($key, $value) {
            return "$key = :where_$key";
        }, array_keys($whereConditions), $whereConditions));

        $sql = "UPDATE $table SET $updateColumnsString WHERE $whereConditionsString";

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($whereConditions as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        $result = $stmt->execute();

        return $result;
    }


    public function delete($table, $whereConditions)
    {
        // Xây dựng phần WHERE
        ///whereConditions là 1 mảng với key và value
        $whereConditionsString = implode(' AND ', array_map(function ($key, $value) {
            return "$key = :where_$key";
        }, array_keys($whereConditions), $whereConditions));

        $sql = "DELETE FROM $table WHERE $whereConditionsString";

        $stmt = $this->pdo->prepare($sql);
        foreach ($whereConditions as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        $stmt->execute();

        return $stmt->rowCount();
    }
}
