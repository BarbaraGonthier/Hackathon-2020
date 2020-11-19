<?php

namespace App\Model;

class OrderManager extends AbstractManager
{
    public const TABLE = 'order';
    public const IN_PROGRESS = 'In progress';
    public const VALIDATED = 'Validated';
    public const REFUSED = 'Refused';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllInProgress()
    {
        return $this->pdo->query(
            "SELECT *, DATE_FORMAT(o.date, \"%d/%m/%Y\") as order_date, e.name as equipment, o.id as id" .
            " FROM `" . self::TABLE . "` o" .
            " JOIN " . EquipmentManager::TABLE . " e ON o.equipment_id = e.id" .
            " WHERE status = '" . self::IN_PROGRESS . "' ORDER BY o.date"
        )->fetchAll();
    }

    public function selectAllValidatedRefused()
    {
        return $this->pdo->query(
            "SELECT *, DATE_FORMAT(o.date, \"%d/%m/%Y\") as order_date, e.name as equipment, o.id as id" .
            " FROM `" . self::TABLE . "` o" .
            " JOIN " . EquipmentManager::TABLE . " e ON o.equipment_id = e.id" .
            " WHERE status = '" . self::VALIDATED . "' OR status = '" . self::REFUSED . "' ORDER BY o.date"
        )->fetchAll();
    }

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT *, DATE_FORMAT(o.date, \"%d/%m/%Y\") as order_date, e.name as equipment, e.stock as stock," .
            " o.id as id, o.user_name as user, o.user_serial_number as serial_number" .
            " FROM `" . self::TABLE . "` o" .
            " JOIN " . EquipmentManager::TABLE . " e ON o.equipment_id = e.id" .
            " WHERE o.id = :id"
        );
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function acceptOrder(int $id, string $action)
    {
        $success = false;

        $statement = $this->pdo->prepare("UPDATE `" . self::TABLE . "` SET status = :action WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('action', $action, \PDO::PARAM_STR);
        $success = $statement->execute();

        if ($action == self::VALIDATED) {
            $statement = $this->pdo->prepare(
                "UPDATE " . EquipmentManager::TABLE . " SET stock = stock - 1 WHERE id=:id"
            );
            $statement->bindValue('id', $id, \PDO::PARAM_INT);
            $success = $statement->execute();
        }

        return $success;
    }
}
