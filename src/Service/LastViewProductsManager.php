<?php 

namespace App\Service;

use App\Entity\Product;

class LastViewProductsManager
{
    public function getLastViewProductsId(Product $product)
    {   
        if (isset($_SESSION['lastView'])) {
            $lastViewProductsId = array_unique($_SESSION['lastView']);
        } 

        $_SESSION['lastView'][] = $product->getId();
        
        return $lastViewProductsId ?? null;    
    }
    
}