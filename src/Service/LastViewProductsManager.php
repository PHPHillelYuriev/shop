<?php 

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

class LastViewProductsManager implements ConstInterface
{
    private $session;
    private $repository;
    private $lastView;

    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
        $this->lastView = $session->get(ConstInterface::SESSION_LAST_PRODUCT_ID);
    }

    public function addLastViewProducts(Product $product)
    {
        if (empty($this->lastView)) {
            $this->addProductIdToSession($product);

            return;
        }

        if (!(in_array($product->getId(), $this->lastView))){
            $this->addProductIdToSession($product);
        }
    }

    public function getLastViewProducts() :array
    {
        $res = [];

        if ($this->session->has(ConstInterface::SESSION_LAST_PRODUCT_ID) && isset($this->lastView)) {
            foreach ($this->lastView as $productId) {
                $res[] = $this->repository->find($productId);
            }
        }

        return $res;
    }

    private function addProductIdToSession($product)
    {
        $this->lastView[] = $product->getId();
        $this->session->set(ConstInterface::SESSION_LAST_PRODUCT_ID, $this->lastView);
    }
}