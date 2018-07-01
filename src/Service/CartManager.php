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
        if ($this->session->has(self::SESSION_CART_ID) && isset($this->session->get(self::SESSION_CART_ID)[$product->getId()])) {
            $this->session->set(self::SESSION_CART_ID,
                [$product->getId() => $this->session->get(self::SESSION_CART_ID)[$product->getId()] += $quantity]
            );

            return;
        }

        $this->session->set(self::SESSION_CART_ID,
            [$product->getId() => $this->session->get(self::SESSION_CART_ID)[$product->getId()] = $quantity]
        );

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
//    public function getProductInfoFromSession($info)
//    {
//        if (isset($_SESSION['cart'])) {S
//            $count = count($_SESSION['cart']);
//            for ($i = 0; $i < $count; $i++) {
//                $result[] = $_SESSION['cart'][$i]["$info"];
//            }
//            return $result;
//        }
//
//        return false;
//    }

//    public function getResultProductsInfo(array $productsInCart, array $productsQuantity): array
//    {
//        $count = count($productsQuantity);
//        for ($i = 0; $i < $count; $i++) {
//            $result[] = [
//                'product' => $productsInCart[$i],
//                'quantity' => $productsQuantity[$i],
//            ];
//        }
//
//        return $result;
//    }

    public function clearCart()
    {   
        if ($this->session->has(self::SESSION_CART_ID)) {
            $this->session->remove(self::SESSION_CART_ID);
        }
    }
}