<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @Route("/shop/{productManufacture}_{productModel}", name="showOneProduct")
     * @ParamConverter("product", options={"mapping": {"productManufacture" = "manufacturer", "productModel" = "model"}})
     */
    public function showOneProduct(Product $product)
    {
        return $this->render('product/product.html.twig', compact('product'));
    }
}
