<?php

namespace App\Controller;

use App\Model\OrderManager;

class AdminOrderController extends AbstractController
{

    public function index()
    {
        $orderManager = new OrderManager();
        $ordersInprogress = $orderManager->selectAllInProgress();
        $ordersValRef = $orderManager->selectAllValidatedRefused();

        return $this->twig->render('Admin/orderList.html.twig', [
            'ordersInProgress' => $ordersInprogress,
            'ordersValRef' => $ordersValRef
        ]);
    }

    public function show(int $id)
    {
        $orderManager = new OrderManager();
        $order = $orderManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $success = $orderManager->acceptOrder((int)$data['id'], $data['action']);
            if ($success) {
                header("Location:/adminOrder/index");
            }
        }

        return $this->twig->render('Admin/orderDetail.html.twig', ['order' => $order]);
    }
}
