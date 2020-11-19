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
        return $this->pdo->query("SELECT *, DATE_FORMAT(o.date, \"%d/%m/%Y\") as order_date, e.name as equipment" .
            " FROM `" . self::TABLE . "` o" .
            " JOIN " . EquipmentManager::TABLE . " e ON o.equipment_id = e.id" .
            " WHERE status = '" . self::IN_PROGRESS . "'" .
            " ORDER BY o.date")->fetchAll();
    }

    public function selectAllValidatedRefused()
    {
        return $this->pdo->query("SELECT *, DATE_FORMAT(o.date, \"%d/%m/%Y\") as order_date, e.name as equipment" .
            " FROM `" . self::TABLE . "` o" .
            " JOIN " . EquipmentManager::TABLE . " e ON o.equipment_id = e.id" .
            " WHERE status = '" . self::VALIDATED . "' OR status = '" . self::REFUSED . "'" .
            " ORDER BY o.date")->fetchAll();
    }
}
