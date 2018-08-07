<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use App\Entity\Orders;
use App\Entity\OrderPosition;
use App\Form\OrdersType;
use Symfony\Component\HttpFoundation\Request;

class OrderManager implements ConstInterface
{
    private $session;
    private $productRepository;
    private $formFactory;
    private $entityManager;
    private $cartManager;

    public function __construct(
        SessionInterface $session,
        ProductRepository $productRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        CartManager $cartManager
    ) {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->cartManager = $cartManager;
    }

    public function addOrder(Request $request)
    {
        $order = new Orders();
        $orderForm = $this->formFactory->create(OrdersType::class, $order);
        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $order = $orderForm->getData();
            $this->entityManager->persist($order);

            $cart = $this->session->get(ConstInterface::SESSION_CART_ID);
            foreach ($cart as $productId => $quantity) {
                $price = $this->productRepository->find($productId)->getPrice();
                $orderPosition = new OrderPosition($price, $quantity, $productId, $order);
                $this->entityManager->persist($orderPosition);
            }
            $this->entityManager->flush();

            $this->cartManager->clearCart();
            
            return $order;
        }

        return 'Error !!!';
    }
}