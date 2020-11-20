<?php

namespace App\Controller;

use App\Model\EquipmentManager;

class AdminEquipmentController extends AbstractController
{
    public function index()
    {
        $equipmentManager = new EquipmentManager();
        $equipments = $equipmentManager->selectAll();

        return $this->twig->render('Admin/equipmentList.html.twig', [
            'equipments' => $equipments,
        ]);
    }
}
