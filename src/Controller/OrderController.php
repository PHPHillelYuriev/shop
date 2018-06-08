<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/OneTech")
 */
class OrderController extends Controller
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        return $this->render('order/cart.html.twig');
    }
}
