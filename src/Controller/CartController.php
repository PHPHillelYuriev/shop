<?php

namespace App\Controller;

use App\Entity\Orders;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\CartManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\OrdersType;

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
        $order = new Orders();
        $cart = $this->get(CartManager::class)->getCart();
        $orderForm = $this->createForm(OrdersType::class, $order);

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
            'orderForm' => $orderForm->createView(),
        ]);
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

    /**
     * @Route("/cart/delete-from-cart/{product}", name="deleteProductFromCart")
     */
    public function deleteProductFromCart(Request $request, Product $product)
    {
        $referrer = $request->headers->get('referer');

        $this->get(CartManager::class)->deleteFromCart($product);

        return $this->redirect($referrer);
    }

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
