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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
    public function showOneProduct(ProductRepository $productRepository, Product $product)
    {          
        $lastViewProductsId = $this->get(LastViewProductsManager::class)->getLastViewProductsId($product);

        if ($lastViewProductsId !== null) {
            $lastViewProducts = $productRepository->getProductsFromArrayId($lastViewProductsId);
        } else {
            $lastViewProducts = null;
        }

        $form = $this->get(FormManager::class)->createCartForm($product);

        return $this->render('product/product.html.twig', compact('product', 'lastViewProducts', 'form'));     
    }
}
