<?php 

namespace App\Service;

use App\Entity\Product;

class LastViewProductsManager
{
    public function getLastViewProducts(Product $product)
    {
        if (isset($_SESSION['lastView'])) {
            $lastViewProducts = array_unique($_SESSION['lastView']);
        } else {
            session_start();
            $lastViewProducts = null;    
        }

        $_SESSION['lastView'][] = $product;
        
        return $lastViewProducts;    
    }
    
}