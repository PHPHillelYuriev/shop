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

    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }

    public function addLastViewProducts(Product $product)
    {
        $lastView = $this->session->get(self::SESSION_LAST_PRODUCT_ID);

        if (empty($lastView)) {
            $lastView[] = $product->getId();
            $this->session->set(self::SESSION_LAST_PRODUCT_ID, $lastView);

            return;
        }

        if(!(in_array($product->getId(), $lastView))){
            $lastView[] = $product->getId();
            $this->session->set(self::SESSION_LAST_PRODUCT_ID, $lastView);
        }
    }

    public function getLastViewProducts()
    {
        $res = [];
        $lastView = $this->session->get(self::SESSION_LAST_PRODUCT_ID);

        if ($this->session->has(self::SESSION_LAST_PRODUCT_ID) && isset($lastView)) {
            foreach ($lastView as $productId) {
                $res[] = $this->repository->find($productId);
            }
        }

        return $res;
    }
    
}