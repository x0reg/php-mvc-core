<?php


class GameModel extends AppQuery
{
    protected $table = "z_list_game";


    const STATUS_LOSE = "Thua";
    const STATUS_WIN = "Chiến Thắng ✅";

    public function getInfoGame($cmt)
    {
        return $this->getRows($this->table, ["comment" => $cmt]);
    }

    public function getAllGame()
    {
        return $this->getAll($this->table);
    }



    public function getPhoneMomo($conditions = [])
    {
        $sql = "SELECT * FROM bank WHERE ";
        $whereConditions = [];
        $bindValues = [];

        foreach ($conditions as $conditionGroup) {
            $groupConditions = [];
            foreach ($conditionGroup as $column => $value) {
                if ($column === 'OR') {
                    $orConditions = [];
                    foreach ($value as $orColumn => $orValue) {
                        $orConditions[] = "$orColumn = :$orColumn";
                        $bindValues[":$orColumn"] = $orValue;
                    }
                    $groupConditions[] = '(' . implode(' OR ', $orConditions) . ')';
                } else {
                    $groupConditions[] = "$column = :$column";
                    $bindValues[":$column"] = $value;
                }
            }
            $whereConditions[] = '(' . implode(' AND ', $groupConditions) . ')';
        }

        $sql .= implode(' AND ', $whereConditions);
        $sql .= " ORDER BY SoDu ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindValues);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows[0];
    }
}
