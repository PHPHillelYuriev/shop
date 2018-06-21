<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\CartManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;

/**
 * @Route("/OneTech")
 */
class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart")
     */
    public function cart(ProductRepository $productRepository)
    {   
        $productsId = $this->get(CartManager::class)->getProductInfoFromSession('productId');
        $productsQuantity = $this->get(CartManager::class)->getProductInfoFromSession('quantity');
        
        if ($productsId) {
            $productsInCart = $productRepository->getProductsFromArrayId($productsId);
            $resultProductsInfo = $this->get(CartManager::class)->getResultProductsInfo($productsInCart, $productsQuantity);            
        } else {
            $resultProductsInfo = null;
        }

        return $this->render('cart/cart.html.twig', compact('resultProductsInfo'));
    }

    /**
     * @Route("/cart/add_to_cart", name="addToCart")
     */
    public function addToCart(Request $request)
    {   
        $referrer = $request->headers->get('referer');

        $product = $this->get(CartManager::class)->setProductInfoToSession($request);

        return $this->redirect($referrer);
    }
}
