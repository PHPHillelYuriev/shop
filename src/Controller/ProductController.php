<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\LastViewProductsManager;
use App\Service\FormManager;

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
        $lastViewProducts = $this->get(LastViewProductsManager::class)->getLastViewProducts();
        $this->get(LastViewProductsManager::class)->addLastViewProducts($product);

        $form = $this->get(FormManager::class)->createCartForm($product);

        return $this->render('product/product.html.twig', compact('product', 'lastViewProducts', 'form'));     
    }
}
