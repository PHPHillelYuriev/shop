<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/OneTech")
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/products", name="showProducts")
     */
    public function showProducts(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('admin/product.html.twig', compact('products'));
    }



    /**
     * @Route("/admin/orders", name="showOrders")
     */
    public function showOrders(OrdersRepository $ordersRepository)
    {
        $orders = $ordersRepository->findAll();

        return $this->render('admin/order.html.twig', compact('orders'));
    }
}
