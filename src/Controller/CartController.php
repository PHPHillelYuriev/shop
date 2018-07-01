<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\CartManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Entity\Product;

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
//        $productsId = $this->get(CartManager::class)->getProductInfoFromSession('productId');
//        $productsQuantity = $this->get(CartManager::class)->getProductInfoFromSession('quantity');
//
//        if ($productsId) {
//            $productsInCart = $productRepository->getProductsFromArrayId($productsId);
//            $resultProductsInfo = $this->get(CartManager::class)->getResultProductsInfo($productsInCart, $productsQuantity);
//        } else {
//            $resultProductsInfo = null;
//        }

        return $this->render('cart/cart.html.twig', ['cart' => $this->get(CartManager::class)->getCart()]);
    }

    /**
     * @Route("/cart/add-to-cart/{product}", name="addProductToCart")
     */
    public function addProductToCart(Request $request, Product $product)
    {   
        $referrer = $request->headers->get('referer');

        $this->get(CartManager::class)->addToCart(
            $product,
            $request->request->get('form')['quantity']
        );

        return $this->redirect($referrer);
    }

//    /**
//     * @Route("/cart/delete-from-cart", name="deleteProductFromCart")
//     */
//    public function deleteProductFromCart(Request $request)
//    {
//        $referrer = $request->headers->get('referer');
//
//        $this->get(CartManager::class)->deleteFromCart();
//
//        return $this->redirect($referrer);
//    }

    /**
     * @Route("/cart/clear-cart", name="claerCart")
     */
    public function claerCart(Request $request)
    {   
        $referrer = $request->headers->get('referer');

        $this->get(CartManager::class)->clearCart();

        return $this->redirect($referrer);
    }
}
