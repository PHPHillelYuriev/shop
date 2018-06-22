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
     * @Route("/cart/add_to_cart", name="addProductToCart")
     */
    public function addProductToCart(Request $request)
    {   
        $referrer = $request->headers->get('referer');

        $this->get(CartManager::class)->setProductInfoToSession($request);

        return $this->redirect($referrer);
    }

    /**
     * @Route("/cart/clear_cart", name="claerCart")
     */
    public function claerCart(Request $request)
    {   
        $referrer = $request->headers->get('referer');
        $data = 'cart';

        $this->get(CartManager::class)->deleteDataFromSession($data);

        return $this->redirect($referrer);
    }
}
