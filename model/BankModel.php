<?php

class BankModel extends AppQuery
{
    public function getPhoneMomo($conditions = [])
    {
        // Tạo câu truy vấn
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
        // Lấy kết quả
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows[0];
    }
}
