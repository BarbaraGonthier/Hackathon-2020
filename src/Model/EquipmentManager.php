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
}
