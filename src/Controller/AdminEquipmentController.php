<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\EquipmentManager;

class AdminEquipmentController extends AbstractController
{
    public function add()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equipment = array_map('trim', $_POST);
            $errors = $this->equipmentValidate($equipment);
            if (empty($errors)) {
                if (!empty($_FILES['image']['name'])) {
                    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $newFileName = uniqid() . '.' . $fileExtension;
                    $uploadDir = 'uploads/equipment/';
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newFileName);
                    $equipment['image'] = $newFileName;
                }
                $equipmentManager = new EquipmentManager();
                $equipmentManager->insert($equipment);
                header('Location:/AdminEquipment/index');
                return "New equipment duly added";
            }
        }
        return $this->twig->render('Admin/equipmentAdd.html.twig', [
            'errors' => $errors ?? [],
            'equipment' => $equipment ?? [],
            'categories' => $categories,
        ]);
    }
    /**
     * @param array $equipment
     * @return array
     * @SuppressWarnings(PHPMD)
     */
    private function equipmentValidate(array $equipment): array
    {
        $inputLength = 255;
        $extensions = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
        $maxSize = 500000;

        $errors = [];

        if (empty($equipment['name'])) {
            $errors[] = 'The field name is mandatory';
        }
        if (!empty($equipment['name']) && strlen($equipment['name']) > $inputLength) {
            $errors[] = 'The field name should be less than ' . $inputLength . ' characters';
        }
        if (empty($equipment['price'])) {
            $errors[] = 'The field price is mandatory';
        }
        if (empty($equipment['stock'])) {
            $errors[] = 'The field stock is mandatory';
        }
        if (empty($equipment['description'])) {
            $errors[] = 'The field description is mandatory';
        }
        if (
            !empty($_FILES['image']['tmp_name']) &&
            !in_array(mime_content_type($_FILES['image']['tmp_name']), $extensions)
        ) {
            $errors[] = 'The file should be png, gif, jpg or jpeg';
        }
        if (!empty($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxSize) {
            $errors[] = 'The file should be less than ' . $maxSize / 100000 . " Mo";
        }

        return $errors ?? [];
    }
    public function index()
    {
        $equipmentManager = new EquipmentManager();
        $equipments = $equipmentManager->selectAll();

        return $this->twig->render('Admin/equipmentList.html.twig', [
            'equipments' => $equipments
        ]);
    }

    public function show(int $id)
    {
        $equipmentManager = new EquipmentManager();
        $equipment = $equipmentManager->selectOneById($id);
        $isOrdered = $equipmentManager->isOrdered($id);

        return $this->twig->render('Admin/equipmentDetail.html.twig', [
            'equipment' => $equipment,
            'isOrdered' => $isOrdered
        ]);
    }

    public function delete(int $id)
    {
        $equipmentManager = new EquipmentManager();
        $equipmentManager->delete($id);
        header('Location:/adminEquipment/index');
    }
}
