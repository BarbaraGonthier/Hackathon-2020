<?php

namespace App\Model;

class OrderManager extends AbstractManager
{
    public const TABLE = '`order`';
    public const IN_PROGRESS = 'In progress';
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function saveOrder(array $order, $equipment)
    {
        $query = "INSERT INTO " . self::TABLE .
            " (`user_name`, `user_serial_number`, `message`, `equipment_id`, `date`, `status`) 
            VALUES 
            (:user_name, :user_serial_number, :message,
            :equipment_id, :date, '" . self::IN_PROGRESS . "')";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':user_name', $order['user_name'], \PDO::PARAM_STR);
        $statement->bindValue(':user_serial_number', $order['user_serial_number'], \PDO::PARAM_STR);
        $statement->bindValue(':message', $order['message'], \PDO::PARAM_STR);
        $statement->bindValue(':equipment_id', $equipment['id'], \PDO::PARAM_INT);
        $statement->bindValue(':date', $order['date'], \PDO::PARAM_INT);


        $statement->execute();
    }
}
