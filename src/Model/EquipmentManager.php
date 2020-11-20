<?php

namespace App\Model;

class EquipmentManager extends AbstractManager
{
    public const TABLE = 'equipment';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllByCategory(int $categoryId)
    {
        $statement = $this->pdo->prepare("SELECT e.*, c.name AS category_name FROM " . self::TABLE .
            " AS e JOIN category AS c ON e.category_id = c.id WHERE e.category_id = :categoryId");
        $statement->bindValue(':categoryId', $categoryId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT e.*, c.name as category, e.id as id" .
            " FROM " . self::TABLE . " e" .
            " JOIN " . CategoryManager::TABLE . " c ON e.category_id = c.id" .
            " WHERE e.id = :id"
        );
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
