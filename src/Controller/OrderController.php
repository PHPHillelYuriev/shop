<?php

namespace App\Controller;

use App\Entity\Orders;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Service\OrderManager;

class OrderController extends Controller
{
    /**
     * @Route("/order", name="addOrder")
     */
    public function order(Request $request)
    {
        $om = $this->get(OrderManager::class);
        $order = $om->addOrder($request);

        //if order add
        if ($order instanceof Orders) {

            //show flash message
            $message = 'You order was sended!';
            $this->addFlash('success', $message);

            return $this->redirectToRoute('cart');
        }

        $this->addFlash('error', $message);
        return $this->redirectToRoute('cart');
    }
}