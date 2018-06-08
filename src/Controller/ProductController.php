<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/OneTech")
 */
class ProductController extends Controller
{
    /**
     * @Route("/shop", name="shop")
     */
    public function shop()
    {
        return $this->render('product/shop.html.twig');
    }

    /**
     * @Route("/product", name="product")
     */
    public function product()
    {
        return $this->render('product/product.html.twig');
    }
}
