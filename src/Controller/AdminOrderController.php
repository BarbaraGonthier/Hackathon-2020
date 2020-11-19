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
}
