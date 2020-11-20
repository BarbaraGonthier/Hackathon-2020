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
    public function update(array $equipment): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name=:name, image=:image,
         category_id=:category_id, description=:description, price=:price, stock=:stock WHERE id=:id");
        $statement->bindValue('id', $equipment['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $equipment['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', $equipment['image'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $equipment['category_id'], \PDO::PARAM_INT);
        $statement->bindValue('description', $equipment['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $equipment['price'], \PDO::PARAM_INT);
        $statement->bindValue('stock', $equipment['stock'], \PDO::PARAM_INT);


        return $statement->execute();
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

    public function insert(array $equipment)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name` , `image` ,
         `category_id` , `description` , `price`, `stock`) 
            VALUES (:name , :image , :category_id , :description, :price, :stock)");
        $statement->bindValue('name', $equipment['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', $equipment['image'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $equipment['category'], \PDO::PARAM_INT);
        $statement->bindValue('description', $equipment['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $equipment['price'], \PDO::PARAM_INT);
        $statement->bindValue('stock', $equipment['stock'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
