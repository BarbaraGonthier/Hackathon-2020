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

    public function show(int $id)
    {
        $equipmentManager = new EquipmentManager();
        $equipment = $equipmentManager->selectOneById($id);

        return $this->twig->render('Admin/equipmentDetail.html.twig', ['equipment' => $equipment]);
    }
}
