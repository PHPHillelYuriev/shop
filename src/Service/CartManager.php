<?php 

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

class CartManager
{
    const SESSION_CART_ID = 'cart';

    private $session;
    private $repository;

    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }

    public function addToCart(Product $product, int $quantity)
    {
        $cart = $this->session->get(self::SESSION_CART_ID);

        if ($this->session->has(self::SESSION_CART_ID) && isset($cart[$product->getId()])) {
            $cart[$product->getId()] += $quantity;
            $this->session->set(self::SESSION_CART_ID, $cart);

            return;
        }

        $cart[$product->getId()] = $quantity;
        $this->session->set(self::SESSION_CART_ID, $cart);
    }

    public function getCart() :array
    {
        $res = [];

        if (!($this->session->has(self::SESSION_CART_ID)) || empty($this->session->get(self::SESSION_CART_ID))) {
            return [];
        }

        foreach ($this->session->get(self::SESSION_CART_ID) as $productId => $quantity) {
            $position['quantity'] = $quantity;
            $position['product'] = $this->repository->find($productId);
            $res[] = $position;
        }

        return $res;
    }

    public function deleteFromCart(Product $product)
    {
        $cart = $this->session->get(self::SESSION_CART_ID);

        if ($this->session->has(self::SESSION_CART_ID) && isset($cart[$product->getId()])) {
            unset($cart[$product->getId()]);
            $this->session->set(self::SESSION_CART_ID, $cart);
        }
    }

    public function clearCart()
    {   
        if ($this->session->has(self::SESSION_CART_ID)) {
            $this->session->remove(self::SESSION_CART_ID);
        }
    }
}