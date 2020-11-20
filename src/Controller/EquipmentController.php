<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\EquipmentManager;

class EquipmentController extends AbstractController
{
    public function show(int $categoryId)
    {
        $equipmentManager = new EquipmentManager();
        $equipments = $equipmentManager->selectAllByCategory($categoryId);

        return $this->twig->render('Equipment/show.html.twig', ['equipments' => $equipments]);
    }
}
