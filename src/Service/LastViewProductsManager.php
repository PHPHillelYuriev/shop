<?php 

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

class LastViewProductsManager
{
    const SESSION_LAST_PRODUCT_ID = 'lastView';

    private $session;
    private $repository;
    private $lastView;

    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
        $this->lastView = $session->get(self::SESSION_LAST_PRODUCT_ID);
    }

    public function addLastViewProducts(Product $product)
    {
        if (empty($this->lastView)) {
            $this->lastView[] = $product->getId();
            $this->session->set(self::SESSION_LAST_PRODUCT_ID, $this->lastView);

            return;
        }

        if (!(in_array($product->getId(), $this->lastView))){
            $this->lastView[] = $product->getId();
            $this->session->set(self::SESSION_LAST_PRODUCT_ID, $this->lastView);
        }
    }

    public function getLastViewProducts() :array
    {
        $res = [];

        if ($this->session->has(self::SESSION_LAST_PRODUCT_ID) && isset($this->lastView)) {
            foreach ($this->lastView as $productId) {
                $res[] = $this->repository->find($productId);
            }
        }

        return $res;
    }
}