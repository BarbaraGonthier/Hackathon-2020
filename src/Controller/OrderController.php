<?php

namespace App\Controller;

use App\Model\EquipmentManager;
use App\Model\OrderManager;
use DateTime;

class OrderController extends AbstractController
{
    public function thanks()
    {
        return $this->twig->render('Order/thanks.html.twig');
    }
    public function sendOrder(int $id)
    {
        $order = [];
        $errors = [];

        $equipmentManager = new EquipmentManager();
        $equipment = $equipmentManager->selectOneById($id);

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $order = array_map('trim', $_POST);

            $errors = $this->orderValidate($order);

            if (empty($errors)) {
                $presentTime = new DateTime();
                $order['date'] = $presentTime->format('Ymd');
                $orderManager = new OrderManager();
                $orderManager->saveOrder($order, $equipment);
                header('Location:/');
            }
        }

        return $this->twig->render('Order/order_form.html.twig', ['equipment' => $equipment,
            'order' => $order,
            'errors' => $errors]);
    }
    private function orderValidate(array $order): array
    {
        $inputLength = 100;
        $shortInputLength = 10;
        $errors = [];

        if (empty($order['user_name'])) {
            $errors[] = 'The field name is mandatory';
        }
        if (!empty($order['user_name']) && strlen($order['user_name']) > $inputLength) {
            $errors[] = 'Thie field name should be less than ' . $inputLength . ' characters';
        }
        if (empty($order['user_serial_number'])) {
            $errors[] = 'The field serial number is mandatory';
        }
        if (!empty($order['user_serial_number']) && strlen($order['user_serial_number']) > $shortInputLength) {
            $errors[] = 'The field serial number should be less than ' . $shortInputLength . ' characters';
        }

        return $errors ?? [];
    }
}
